<script>
    export default {
        name: 'SubmitsFormMixin',
        data() {
            return {
                errors: {}
            }
        },
        computed: {
            hasErrors() {
                return Object.keys(this.errors).length > 0;
            }
        },
        methods: {
            onSubmit() {
                axios
                    .post(event.target.action, new FormData(event.target))
                    .then(response => {
                        if (response.data.redirect) {
                            location.href = response.data.redirect;
                        }
                        this.flushErrors();
                    })
                    .catch(error => this.errors = error.response.data.errors || {});
            },
            flushErrors() {
                this.errors = {};
            }
        }
    }
</script>
