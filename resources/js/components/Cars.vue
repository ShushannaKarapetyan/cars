<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card mt-5 mb-5">
                    <div class="card-header">
                        <div class="card-title float-left">
                            <h3>Cars</h3>
                        </div>
                        <div class="form-group float-right">
                            <div class="search-box d-flex">
                                <input type="text"
                                       name="search"
                                       @keydown.enter="getFilteredResult()"
                                       v-model="search"
                                       placeholder="Search by make..."
                                       class="form-control search">
                                <button type="submit" @click="getFilteredResult()">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table v-if="cars.length" class="table table-hover table-striped" v-cloak>
                                <thead class="text-primary">
                                <tr>
                                    <th>ID</th>
                                    <th>Make</th>
                                    <th>Model</th>
                                    <th>Year</th>
                                    <th>Price</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="car in cars" :key="car.id">
                                    <td>{{ car.id }}</td>
                                    <td>{{ car.make}}</td>
                                    <td>{{ car.model}}</td>
                                    <td>{{ car.year}}</td>
                                    <td>{{ car.price}}</td>
                                </tr>
                                </tbody>
                            </table>
                            <h2 v-else>No cars.</h2>
                        </div>
                    </div>
                    <div v-if="cars.length" class="card-footer">
                        <div class="pagination">
                            <ul>
                                <li :class="[{disabled:!pagination.paginate.prev_page_url}]" class="page-item">
                                    <a href="#"
                                       class="page-link"
                                       @click="getPaginateCars(pagination.paginate.prev_page_url)">
                                        Previous
                                    </a>
                                </li>
                                <li class="page-item disabled">
                                    <a class="page-link text-dark" href="#">
                                        Page {{ pagination.paginate.current_page }} of {{ pagination.paginate.last_page
                                        }}
                                    </a>
                                </li>
                                <li :class="[{disabled:!pagination.paginate.next_page_url}]" class="page-item">
                                    <a href="#"
                                       class="page-link"
                                       @click="getPaginateCars(pagination.paginate.next_page_url)">
                                        Next
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Pagination from "../helpers/pagination";

    export default {
        name: "Cars",

        data() {
            return {
                cars: [],
                carList: [],
                search: '',
                url: '/cars',
                pagination: new Pagination(),
                searching: false,
            }
        },

        mounted() {
            this.getCars();
        },

        methods: {
            getCars() {
                this.searching = false;
                axios.get(this.url)
                    .then(response => {
                        this.cars = response.data.cars.data;
                        this.pagination.makePagination(response.data.cars);

                        this.carList = this.cars;
                    })
                    .catch(error => console.log(error));
            },

            getFilteredResult() {
                if (/\S/.test(this.search)) {
                    this.searching = true;

                    axios.get(`${this.url}?search=${this.search}`)
                        .then(response => {
                            this.cars = response.data.cars.data;
                            this.pagination.makePagination(response.data.cars);
                        })
                        .catch(error => console.log(error));
                }

                this.cars = this.carList;
            },

            getPaginateCars(url) {
                this.url = url;

                //this.getCars();

                this.searching ? this.getFilteredResult() : this.getCars();
            },
        }
    }
</script>

<style scoped>
    .search {
        position: relative;
    }

    .search-box button {
        border: none;
        background: transparent;
        right: 20px;
        position: absolute;
        top: 18px;
        color: #a7a2a2;
    }

    .search-box button:focus {
        outline: none;
    }

    .pagination ul {
        list-style: none;
    }

    .pagination ul li {
        float: left;
    }
</style>

