<template>
    <b-card-group deck>

        <clasis v-for="(clasis, index) in classesList" :key="index" :clasis="clasis" @delete="handleDelete(index)"
                @edit="handleEdit(index)"></clasis>

        <b-card bg-variant="light" class="text-center">
            <b-button @click.prevent="addNewClass" variant="link">
                <i class="fa fa-2x fa-plus"></i>
                <br/>{{trans('classes::class.new_class')}}
            </b-button>
        </b-card>

        <b-modal v-if="currentClass" ref="editClassPopup" :title="currentClass.name" @ok="handleOk" @hide="handleHide"
                 no-close-on-backdrop v-model="modalOpen"
                 no-close-on-esc>
            <b-form>

                <b-form-group label="Name">

                    <b-form-input type="text" v-model="currentClass.name"
                                  :placeholder="trans('classes::class.new_class_placeholder')">
                    </b-form-input>
                    <div class="invalid-feedback" v-if="!$v.currentClass.name.required">
                        {{trans('base::validation.required', trans('classes::class.name'))}}
                    </div>
                </b-form-group>

            </b-form>
        </b-modal>

    </b-card-group>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';
    import { required } from 'vuelidate/lib/validators'

    Vue.component('clasis', require('./EditClass'));

    export default {
        components: {
            Datepicker
        },

        mixins: [C.mixins.Routes, C.mixins.Trans],

        props: {
            grade: {
                default: {},
                type: Object
            },
            classes: {
                default: () => [],
                type: Array
            }
        },
        data() {
            return {
                classesList: [],
                currentClass: null,
                currentIndex: null,
                modalOpen: false
            }
        },
        mounted() {

            this.classesList = this.classes;
        },
        validations: {
            currentClass:{
                name: {
                    required
                }
            }
        },
        methods: {

            addNewClass() {

                this.classesList.push({
                    id: null,
                    name: null
                });

                this.handleEdit(this.classes.length - 1);
            },

            handleDelete(index) {

                this.setCurrentIndex(index);

                axios.delete(this.route('grade.class.delete', {
                    id: this.grade.id,
                    cid: this.classes[this.currentIndex].id
                }))
                    .then(this.handleSubmitResponse)
                    .then(() => {

                        this.classes.splice(this.currentIndex, 1);
                    })
                    .catch(this.handleSubmitResponse);
            },

            handleEdit(index) {

                this.setCurrentIndex(index);

                this.cloneObject();

                setTimeout(() => {

                    this.$refs.editClassPopup.show();
                }, 100)
            },

            getRouteForObject() {

                if (!this.currentClass.id) {

                    return this.route('grade.class.new', this.grade.id);
                } else {

                    return this.route('grade.class.edit', {
                        id: this.grade.id,
                        cid: this.currentClass.id
                    });
                }
            },

            handleOk(e) {
                this.$v.$touch();
                e.preventDefault();

                if(this.$v.currentClass.$error){
                    window.C.notification.warning(this.trans('base::common.validation_failed'));
                } else {
                    this.handleSubmit();
                }

            },

            handleHide(){
                if(_.filter(_.values(_.pick(this.currentClass, _.keys(this.$v.currentClass.$params))), item => {
                        return item;
                    }).length <= 0){
                    this.classes.splice(this.currentIndex, 1);
                }
            },

            handleSubmit() {

                axios.post(this.getRouteForObject(), this.currentClass)
                    .then(this.handleSubmitResponse)
                    .then(response => {

                        this.currentClass.id = response.data.data.class.id;

                        this.$set(this.classes, this.currentIndex, Object.assign({}, this.currentClass));

                        this.modalOpen = false;
                    })
                    .catch(this.handleSubmitResponse);
            },

            cloneObject() {

                this.currentClass = Object.assign({}, this.classes[this.currentIndex]);
            },

            setCurrentIndex(index) {

                this.currentIndex = index;
            }
        }
    }
</script>