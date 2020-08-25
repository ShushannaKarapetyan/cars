<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card mt-5 mb-5">
                    <div class="card-header">
                        <div class="card-title float-left">
                            <h3>Cars</h3>
                        </div>
                        <div class="form-group float-right col-md-6">
                            <div class="search-box">
                                <input type="text"
                                       name="search"
                                       v-model="search"
                                       placeholder="Search by make..."
                                       class="form-control search"
                                       :class="{'is-invalid': searchError}"
                                       @keydown.enter="getCars(1)">
                                <button type="submit" @click="getCars(1)">
                                    <i class="fas fa-search"></i>
                                </button>
                                <span class="invalid-feedback" v-if="searchError">{{ searchError }}</span>
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
                    <div v-if="last_page > 1" class="card-footer">
                        <div class="pagination">
                            <ul>
                                <li :class="[{disabled:(!prev_page || searchError)}]"
                                    class="page-item">
                                    <a href="#"
                                       class="page-link"
                                       @click="prev(url + prev_page)">
                                        Previous
                                    </a>
                                </li>
                                <li class="page-item disabled">
                                    <a class="page-link text-dark" href="#">
                                        Page {{ current_page }} of {{
                                        last_page
                                        }}
                                    </a>
                                </li>
                                <li :class="[{disabled:(current_page === last_page || searchError)}]"
                                    class="page-item">
                                    <a href="#"
                                       class="page-link"
                                       @click="next(url + next_page)">
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
    export default {
        name: 'Cars',

        data() {
            return {
                cars: {},
                search: '',
                url: location.origin + location.pathname + '?page=',
                current_page: 1,
                last_page: '',
                next_page: '',
                prev_page: '',
                searchError: '',
            }
        },

        mounted() {
            this.getCars();
        },

        methods: {
            getCars(page) {
                axios.get('/cars', {
                        params: {
                            'page': page || this.current_page,
                            'search': this.search,
                        }
                    }
                )
                    .then(response => {
                        this.searchError = '';

                        this.cars = response.data.cars.data;
                        this.current_page = response.data.cars.current_page;
                        this.next_page = response.data.cars.current_page + 1;
                        this.prev_page = response.data.cars.current_page - 1;
                        this.last_page = response.data.cars.last_page;
                    })
                    .catch(error => {
                        this.searchError = error.response.data.errors.search[0];
                    });
            },

            prev() {
                this.current_page -= 1;

                this.getCars();
            },

            next() {
                this.current_page += 1;

                this.getCars();
            },
        },
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
        top: 8px;
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

