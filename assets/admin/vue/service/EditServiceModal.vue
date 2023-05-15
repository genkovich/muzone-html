<template>
    <div class="modal fade" id="add-new-service-modal" tabindex="-1" aria-labelledby="addNewServiceModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewServiceModalLabel">Додати нову послугу</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрити"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="addNewService" class="needs-validation">
                        <div class="mb-3">
                            <label for="title" class="visually-hidden">Назва</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-pencil-square"></i>
                                </span>
                                <input type="text" class="form-control" id="title" v-model="service.title"
                                       placeholder="Назва" required>
                                <span class="invalid-feedback" v-if="errors.title">{{ errors.title }}</span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="price" class="visually-hidden">Ціна</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-cash"></i>
                                    </span>
                                    <input type="number" min="0" step="0.01" class="form-control" id="price"
                                           v-model="service.price" placeholder="Ціна" required>
                                    <div class="invalid-feedback">
                                        Будь ласка, введіть вартість послуги.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-currency-exchange"></i>
                                    </span>
                                    <select class="form-select" id="currency" v-model="service.currency" required>
                                        <option value="" disabled>Виберіть валюту...</option>
                                        <option v-for="currency in currencies" :key="currency" :value="currency">
                                            {{ currency }}
                                        </option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Будь ласка, виберіть валюту.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="lessons_count" class="visually-hidden">Кількість занять</label>
                            <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-calendar-check"></i>
                            </span>
                                <input type="number" min="1" class="form-control" id="lessons_count"
                                       v-model="service.lessons_count" placeholder="Кількість занять" required>
                                <div class="invalid-feedback">
                                    Будь ласка, введіть кількість занять.
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="age" class="visually-hidden">Вік</label>
                            <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-person"></i>
                            </span>
                                <select class="form-select" id="age" v-model="service.age" required>
                                    <option value="" disabled>Виберіть вікову категорію...</option>
                                    <option v-for="age in ages" :key="age.value" :value="age.value">
                                        {{ age.icon }} {{ age.label }}
                                    </option>
                                </select>
                                <div class="invalid-feedback">
                                    Будь ласка, виберіть вікову категорію.
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрити</button>
                            <button type="submit" class="btn btn-primary" id="save-service-changes">Зберегти зміни</button>
                        </div>
                    </Form>
                </div>
            </div>
        </div>
    </div>
</template>


<style scoped>

</style>

<script setup>
import {defineProps, reactive, watch, onMounted} from 'vue';
import { useField, useForm, defineRule } from 'vee-validate';
import { required, min, numeric, length } from '@vee-validate/rules';
import axios from 'axios';
import toastr from 'toastr';

const props = defineProps(['directions', 'currencies', 'ages', 'create_route']);

let service = reactive({
    title: '',
    direction: '',
    price: '',
    currency: '',
    lessons_count: '',
    age: ''
});

const { form } = useForm(service);

defineRule('required', required);
defineRule('min', min);
defineRule('numeric', numeric);

const { errors, validate } = useForm();

const rules = {
    title: { required: true},
    direction: 'required',
    price: { required: true, numeric: true, min: 0 },
    currency: 'required',
    lessons_count: { required: true, numeric: true, min: 1 },
    age: 'required'
};

Object.keys(service).forEach(key => {
    form[key] = useField(key, rules[key]);
});

onMounted(() => {
    fetchData();
});

function fetchData() {
    // Fetch directions, currencies, ages from your backend or API
    // This is a placeholder, replace with actual calls
}

function addNewService() {
    axios.post(props.create_route, service)
        .then(response => {
            if (response.data.success) {
                toastr.success('Нова послуга успішно додана');
                location.reload();
            } else {
                toastr.error('Помилка при збереженні нової послуги');
            }
        })
        .catch(() => {
            toastr.error('Помилка на боці сервера, спробуйте пізніше або зверніться до адміністратора');
        });
}
</script>