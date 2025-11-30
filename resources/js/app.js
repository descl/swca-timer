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

    _start() {
        if (this.interval) {
            clearInterval(this.interval);
        }

        this.interval = setInterval(() => {
            const now = new Date();
            const diff = new Date(this.endAt * 1000) - now;

            if (diff <= 0) {
                this.element.textContent = "00:00";
                clearInterval(this.interval);
                return;
            }

            const mins = Math.floor(diff / 1000 / 60);
            const secs = Math.floor((diff / 1000) % 60);

            this._setTimeText(mins, secs);
        }, 500);
    }

    _stop() {
        clearInterval(this.interval);
        this._setTimeText(0, 0);
    }

    _setTimeText(mins, secs) {
        this.element.textContent = `${String(mins).padStart(2, "0")}:${String(
            secs
        ).padStart(2, "0")}`;
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
