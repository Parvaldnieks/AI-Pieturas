export default function syncTracker(batchId) {
    return {
        batchId,
        total: 0,
        processed: 0,
        progress: 0,
        loading: true,
        finished: false,
        visible: true,

        start() {
            this.check();
            this.timer = setInterval(() => this.check(), 2000);
        },

        check() {
            fetch(`/sync/progress/${this.batchId}`)
                .then(res => res.json())
                .then(data => {
                    if (data.error) return;

                    this.total = data.total;
                    this.processed = data.processed;
                    this.progress = data.progress;
                    this.loading = false;

                    if (data.finished) {
                        this.finished = true;

                        setTimeout(() => {
                            this.visible = false;
                        }, 700);

                        clearInterval(this.timer);
                    }
                });
        }
    };
}
