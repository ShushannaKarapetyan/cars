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
                                       @keyup="getSearchResult()"
                                       v-model="search"
                                       placeholder="Search by make..."
                                       class="form-control search">
                                <button type="submit" @click="getSearchResult()">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table v-if="cars.length" class="table table-hover table-striped">
                                <thead class="text-primary">
                                <tr>
                                    <th>N</th>
                                    <th>Make</th>
                                    <th>Model</th>
                                    <th>Year</th>
                                    <th>Price</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(car, index) in cars" :key="index">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ car.make}}</td>
                                    <td>{{ car.model}}</td>
                                    <td>{{ car.year}}</td>
                                    <td>{{ car.price}}</td>
                                </tr>
                                </tbody>
                            </table>
                            <h2 v-else v-cloak>No cars.</h2>
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
                search: '',
                url: '/cars',
                pagination: new Pagination(),
            }
        },

        mounted() {
            this.getCars();
        },

        methods: {
            getCars() {
                axios.get(this.url)
                    .then(response => {
                        this.cars = response.data.cars.data;
                        this.pagination.makePagination(response.data.cars);
                    })
                    .catch(error => console.log(error));
            },

            getSearchResult() {
                if (this.search.length > 2) {
                    axios.get(`/cars?search=${this.search}`)
                        .then(response => {
                            this.cars = response.data.cars.data;
                        })
                        .catch(error => console.log(error));
                }
            },

            getPaginateCars(url) {
                this.url = url;
                this.getCars();
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

