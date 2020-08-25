<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-5">
                    <div class="card-header">
                        Create Car
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="add">
                            <div class="card-body">
                                <div class="form-group col-md-12">
                                    <label for="make">Make</label>
                                    <input type="text"
                                           id="make"
                                           placeholder="Make"
                                           v-model="car.make"
                                           class="form-control"
                                           :class="{'is-invalid': errors.hasOwnProperty('make')}"
                                           name="make">
                                    <span v-if="errors.hasOwnProperty('make')" class="invalid-feedback"
                                          v-text="errors.make[0]"></span>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="model">Model</label>
                                    <input type="text"
                                           id="model"
                                           placeholder="Model"
                                           v-model="car.model"
                                           class="form-control"
                                           :class="{'is-invalid': errors.hasOwnProperty('model')}"
                                           name="model">
                                    <span v-if="errors.hasOwnProperty('model')" class="invalid-feedback"
                                          v-text="errors.model[0]"></span>
                                </div>
                                <div class="year-and-price col-md-12">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="year">Select Year</label>
                                            <date-picker
                                                id="year"
                                                v-model="dateFull"
                                                type="year"
                                                format="YYYY"
                                                placeholder="Year"
                                                class="w-100"
                                                :class="{'is-invalid': errors.hasOwnProperty('year')}"
                                                :input-class="{'form-control':true, 'is-invalid': errors.hasOwnProperty('year')}"
                                            >
                                            </date-picker>
                                            <span v-if="errors.hasOwnProperty('year')"
                                                  class="invalid-feedback"
                                                  v-text="errors.year[0]"></span>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="price">Price</label>
                                            <input type="text"
                                                   id="price"
                                                   placeholder="Price"
                                                   v-model="car.price"
                                                   class="form-control"
                                                   :class="{'is-invalid': errors.hasOwnProperty('price')}"
                                                   name="price">
                                            <span v-if="errors.hasOwnProperty('price')" class="invalid-feedback"
                                                  v-text="errors.price[0]"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-success">Add</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import DatePicker from 'vue2-datepicker';
    import 'vue2-datepicker/index.css';

    export default {
        name: 'Create',

        components: {
            DatePicker,
        },

        data() {
            return {
                car: {
                    make: '',
                    model: '',
                    year: '',
                    price: '',
                },
                dateFull: '',
                errors: [],
            }
        },

        methods: {
            add() {
                this.car.year = new Date(this.dateFull).getFullYear();

                if (!this.dateFull) {
                    this.car.year = '';
                }

                axios.post('/cars', this.$data.car)
                    .then(response => {
                        this.car.make = '';
                        this.car.model = '';
                        this.dateFull = '';
                        this.car.price = '';

                        this.clear();

                        this.$swal('Done!', response.data.message, 'success');
                    })
                    .catch(error => {
                        this.errors = error.response.data.errors;
                    });
            },

            clear(field) {
                if (field) {
                    delete this.errors[field];

                    return;
                }

                this.errors = [];
            },
        },
    }
</script>
