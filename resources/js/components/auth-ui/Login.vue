<template>
    <div class="login-window">

        <div class="title">Вход</div>

        <form method="POST" action="#" id="login" class="col-12">
            <div class="row">
                <label for="last_name" class="col-md-4 col-form-label text-md-right">E-mail</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="login-input" name="email" required autocomplete="email" autofocus>
                </div>
            </div>

            <div class="row">
                <label for="first_name" class="col-md-4 col-form-label text-md-right">Пароль</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="login-input" name="password" required autocomplete="current-password">
                </div>
            </div>
        </form>

        <div class="buttons clearfix">
            <button type="submit" class="" v-on:click="closeLogin">
                Отмена
            </button>
            <button type="submit" class="" v-on:click="login">
                Войти
            </button>
        </div>
    </div>
</template>

<script>
export default {
    props: {

    },
    data: function () {
        return {
            loading: true,
        }
    },
    methods: {
        login: function () {
            let csrf = document.getElementsByName("_token")[0];
            let form = document.getElementById('login');

            form.appendChild(csrf);

            form.submit();
        },
        closeLogin: function () {
            this.$emit('close-login');
        }
    },
    mounted: function () {

    }
}
</script>