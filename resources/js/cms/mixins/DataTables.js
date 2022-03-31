export default {
    props: {
        fetchUrl: { type: String, required: false }
    },

    data() {
        return {
            tableData: [],
            url: "",
            pagination: {
                meta: { to: 1, from: 1 }
            },
            offset: 2,
            currentPage: 1,
            perPage: 10,
            sortedColumn: "id",
            order: "asc",
            loading: false,
            filter: ""
        };
    },

    watch: {
        fetchUrl: {
            handler(fetchUrl) {
                if (fetchUrl) {
                    this.url = fetchUrl;
                }
            },
            immediate: true
        },
    },

    created() {
        this.fetchData();

        window.events.$on("fetchData", () => {
            this.fetchData();
        });
    },

    filters: {
        columnHead(value) {
            value = value.toString();
            value = value.split(' ');

            return value.map(str => str.charAt(0).toUpperCase() + str.slice(1)).join(' ');
        }
    },

    computed: {
        /**
         * Get the pages number array for displaying in the pagination.
         * */
        pagesNumber() {
            if (!this.pagination.meta.to) {
                return [];
            }

            let from = this.pagination.meta.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }

            let to = from + this.offset * 2;
            if (to >= this.pagination.meta.last_page) {
                to = this.pagination.meta.last_page;
            }

            let pagesArray = [];
            for (let page = from; page <= to; page++) {
                pagesArray.push(page);
            }

            return pagesArray;
        }
    },

    methods: {
        async fetchData() {
            let dataFetchUrl = `${this.url}?page=${this.currentPage}&column=${this.sortedColumn
                }&order=${this.order}&per_page=${this.perPage}&filter=${this.filter}`;

            this.loading = true;

            if (this.extraParams) {
                dataFetchUrl = `${dataFetchUrl}&${this.extraParams}`
            }

            await axios
                .get(dataFetchUrl)
                .then(({ data }) => {
                    this.loading = false;
                    this.pagination = data;
                    this.tableData = data.data;
                })
                .catch(error => (this.tableData = []));

            // reload if there's no data on current page
            if (this.currentPage > this.pagination.meta.last_page && this.tableData.length === 0) {
                this.currentPage = this.pagination.meta.last_page;
                this.fetchData();
            }
        },

        /**
         * Change the page.
         * @param pageNumber
         */
        changePage(pageNumber) {
            this.currentPage = pageNumber;
            this.fetchData();
        },

        /**
         * Sort the data by column.
         * */
        sortByColumn(column) {
            if (this.sortables.hasOwnProperty(column)) {
                if (column === this.sortedColumn) {
                    this.order = this.order === "asc" ? "desc" : "asc";
                } else {
                    this.sortedColumn = column;
                    this.order = "asc";
                }

                this.fetchData();
            }
        },
    }
}
