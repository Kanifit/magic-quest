<template>
    <div class="empty-container">
        <span class="empty-text ">Увы! Квест не найден :(</span>
    </div>
</template>

<script>
    export default {
        name: "EmptyTest"
    }
</script>

<style>
    .empty-container {
        padding: 40px 0;
        text-align: center;
        background: linear-gradient(120deg, #8ec5fc 0%, #8ec5fc 50%, #e0c3fc 100%);
        overflow: hidden;
    }
    .empty-text {
        text-align: center;
        font-size: 40px;
        position: relative;
        color: rgb(255, 255, 255);
        animation: empty 1.5s;
        animation-duration: 1.5s;
    }

    @keyframes empty {
        from {left:-100%;}
        to {left:0;}
    }

</style>
