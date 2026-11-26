import "./bootstrap";

import.meta.glob(["../images/**"]);

const requestApi = async (method, timerId, endpoint, body) => {
    try {
        const response = await fetch(`/api/timer/${timerId}/${endpoint}`, {
            method: method,
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
            },
            body: body ? JSON.stringify(body) : null,
        });

        if (response.status !== 200) {
            throw new Error(
                `API request failed with status ${response.status}`
            );
        }
        if (response.headers.get("Content-Type").includes("application/json")) {
            return await response.json();
        }

        return null;
    } catch (error) {
        console.error("API request error:", error);
        throw error;
    }
};

class Timer {
    id = 1;
    element = null;
    endAt = null;
    interval = null;
    syncInterval = null;

    constructor(id) {
        this.id = id;
    }

    init() {
        this.element = document.getElementById("time");
        this._startSync();
    }

    _startSync() {
        this._sync();
        this.syncInterval = setInterval(this._sync.bind(this), 1000);
    }

    async _sync() {
        try {
            const data = await requestApi("GET", this.id, "status");

            if (data.end_at === this.endAt) return;

            this.endAt = data.end_at;
            this._start();
        } catch (error) {
            console.error("Failed to sync timer status:", error);
        }
    }

    // Duree d'affichage de l'ecran "Temps ecoule" avant de revenir a l'attente
    static FINISHED_DISPLAY_MS = 60_000;
    // Seuil de l'alerte de fin (rouge + clignotement)
    static ENDING_THRESHOLD_S = 5;

    _start() {
        if (this.interval) {
            clearInterval(this.interval);
            this.interval = null;
        }

        this._tick();
        if (this.endAt) {
            this.interval = setInterval(this._tick.bind(this), 250);
        }
    }

    _tick() {
        if (!this.endAt) {
            this._setTimeText(0, 0, "--:--");
            this._setState("idle");
            return;
        }

        const diff = this.endAt * 1000 - Date.now();

        if (diff > 0) {
            // Arrondi au superieur : "00:01" reste affiche jusqu'a la toute fin
            const total = Math.ceil(diff / 1000);
            this._setTimeText(Math.floor(total / 60), total % 60);
            this._setState(total <= Timer.ENDING_THRESHOLD_S ? "ending" : "running");
            return;
        }

        if (-diff < Timer.FINISHED_DISPLAY_MS) {
            this._setTimeText(0, 0);
            this._setState("finished");
            return;
        }

        this._setTimeText(0, 0, "--:--");
        this._setState("idle");
        clearInterval(this.interval);
        this.interval = null;
    }

    _setState(state) {
        const display = document.getElementById("display");
        if (display && display.dataset.timerState !== state) {
            display.dataset.timerState = state;
        }
    }

    _setTimeText(mins, secs, text = null) {
        if (!this.element) return;
        this.element.textContent =
            text ??
            `${String(mins).padStart(2, "0")}:${String(secs).padStart(2, "0")}`;
    }
}

class Controls {
    timerId = null;
    timeInput = null;
    startFavoriteButtons = [];
    startButton = null;
    stopButton = null;

    constructor(timerId) {
        this.timerId = timerId;
        this.timeInput = document.getElementById("timeInput");
        this.startFavoriteButtons = Array.from(
            document.querySelectorAll(".start-favorite")
        );
        this.startButton = document.getElementById("startButton");
        this.stopButton = document.getElementById("stopButton");
    }

    init() {
        this.startFavoriteButtons.forEach((button) => {
            button.addEventListener("click", () => {
                const duration = button.getAttribute("data-duration");
                this.timeInput.value = duration;
            });
        });
        this.startButton.addEventListener("click", () => {
            this._start();
        });
        this.stopButton.addEventListener("click", () => {
            this._stop();
        });
    }

    async _start() {
        try {
            const duration = parseInt(this.timeInput.value);
            if (isNaN(duration) || duration <= 0) {
                alert("Please enter a valid number of seconds.");
                return;
            }

            await requestApi("POST", this.timerId, "start", { duration });
        } catch (error) {
            alert("Failed to start the timer.");
        }
    }

    async _stop() {
        try {
            await requestApi("POST", this.timerId, "stop");
        } catch (error) {
            alert("Failed to stop the timer.");
        }
    }
}

document.addEventListener("DOMContentLoaded", () => {
    const timerId = 1;

    if (window.location.pathname.includes("controls")) {
        const controls = new Controls(timerId);
        controls.init();
    }

    const timer = new Timer(timerId);
    timer.init();
});
