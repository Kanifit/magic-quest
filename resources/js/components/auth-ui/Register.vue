<template>
    <div class="register-window">
        <transition name="registerwindow">
            <div class="loader-reg" v-if="!regLoaded"></div>
        </transition>

        <div class="title">Регистрация</div>

        <form method="POST" action="#" class="col-12 col-md-8 offset-md-2">

            <div class="row">
                <label for="last_name" class="col-md-4 col-form-label text-md-right">Фамилия</label>

                <div class="col-md-6">
                    <input id="last_name" type="text" class="login-input" name="last_name" required autocomplete="last_name">
                </div>
            </div>

            <div class="row">
                <label for="first_name" class="col-md-4 col-form-label text-md-right">Имя</label>

                <div class="col-md-6">
                    <input id="first_name" type="text" class="login-input" name="first_name" required autocomplete="first_name">
                </div>
            </div>

            <div class="row">
                <label for="middle_name" class="col-md-4 col-form-label text-md-right">Отчество</label>

                <div class="col-md-6">
                    <input id="middle_name" type="text" class="login-input" name="middle_name"  required autocomplete="middle_name">
                </div>
            </div>

            <div class="row">
                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail адрес</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="login-input" name="email" required autocomplete="email">
                </div>
            </div>

            <div class="row">
                <label for="password" class="col-md-4 col-form-label text-md-right">Пароль</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="login-input" name="password" required autocomplete="new-password">
                </div>
            </div>

            <div class="row">
                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Подтверждение пароля</label>

                <div class="col-md-6">
                    <input id="password-confirm" type="password" class="login-input" name="password_confirmation" required autocomplete="new-password">
                </div>
            </div>
        </form>

        <div class="buttons clearfix" v-if="regLoaded">
            <button type="submit" class="" v-on:click="closeRegister">
                Отмена
            </button>
            <button type="submit" class="">
                Зарегистрироваться
            </button>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        regLoaded: Boolean
    },
    data: function () {
        return {
            loading: true,
        }
    },
    methods: {
        closeRegister: function () {
            this.$emit('close-register');
        }
    },
    mounted: function () {

    }
}
</script>