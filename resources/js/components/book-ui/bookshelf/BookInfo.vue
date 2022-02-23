<template>
    <div class="book-info" id="book-info" v-bind:class="[{'skeleton': this.isSkeleton}]">
        <simplebar data-simplebar-auto-hide="true" crollbar-min-size="1">
            <div class="book-cover" id="coverPlase" v-bind:style="{ 'box-shadow': '0 0 20px 5px ' + accentСolor + '80',  }"></div>
            <div class="title" v-if="!isSkeleton">{{ title }}</div>
            <div class="title" v-else></div>
            <div class="author" v-if="!isSkeleton" v-bind:style="{ 'color': accentСolor }">{{ author }}</div>
            <div class="author" v-else></div>
            <div class="description"
                v-bind:class="[{ 'minimize': desc_minimize}]"
                v-if="!isSkeleton"
                v-on:click="descriptionOpener()">
                {{ description }}
                    <div class="desc-open" v-if="desc_minimize">... развернуть</div>
                    <div class="desc-close" v-if="!desc_minimize" v-on:click="descriptionCloser()">свернуть описание</div>
                </div>
            <div class="description" v-else>
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
            </div>
        </simplebar>

        <div class="close-button"><i class="material-icons" v-on:click="closeBookInfo">close</i></div>
        <div class="buttons" v-if="!isSkeleton">
            <div class="reviews">Отзывы</div>
            <div class="reviews"  v-bind:style="{ 'color': accentСolor }" v-on:click="redirectToReader">Читать</div>
            <div class="reviews">Квест</div>
        </div>
    </div>
</template>

<script>
    import simplebar from 'simplebar-vue';
    import MovingBookCover from './MovingBookCover.vue';

    export default {
        props: {
            bookId: Number,
            animationDone: Boolean,
            book: Object,
        },
        components: {
            simplebar
        },
        data: function () {
            return {
                isSkeleton: true,
                accentСolor: null,
                book_info: null,
                title: null,
                author: null,
                description: null,
                link: null,
                desc_minimize: true,
                desc_state: false,
                image: null,
                movingBook: null,
                shifts: {
                    y: 0,
                    x: 0,
                    size_x: 0,
                    size_y: 0,
                    radius: 5
                }
            }
        },
        watch: {
            bookId: function () {

            },
            book_info: function() {

                this.title = this.book_info.title;
                // this.author = this.compileAuthors(this.book_info.authors);
                this.description = this.book_info.description;
                this.link = this.book_info.link;
                this.accentСolor = this.book_info.accentColor;

                this.image = this.book_info.image;

                if (this.animationDone == true)
                    this.setNormalCover();
            },

            animationDone: function() {
                if (this.book_info !== null)
                    this.setNormalCover();
            },

            authors: function () {

            }
        },
        methods: {
            closeBookInfo: function ()
            {
                this.$emit('close-book-info');

                document.body.classList.remove('blockScroll');

                this.shifts.x = 0; this.shifts.y = 0;
                this.movingBook.$destroy();
                this.movingBook = null;
                var books = document.getElementsByClassName('book hide');

                while (books.length) books[0].classList.remove('hide');
            },
            descriptionOpener: function() {
                if (this.desc_minimize && !this.desc_state)
                {
                    this.desc_minimize = false;
                    this.desc_state = true;
                }
            },
            descriptionCloser: function() {
                if (!this.desc_minimize && this.desc_state)
                {
                    this.desc_minimize = true;
                    setTimeout(() => {
                        this.desc_state = false;
                    }, 50);
                }
            },
            setNormalCover: function () {
                this.isSkeleton = false;
                var cover = document.getElementById('moving-book-cover');
                cover.style.backgroundImage = 'url(' + this.image + ')';
            },
            redirectToReader: function() {
                document.location.href = this.link;
            },
            compileAuthors: function(authors) {

                if (authors.length < 1)
                    return 'автор не указан';

                if (authors.length == 1)
                    return 'автор ' + authors[0];

                let _author = 'авторы ';

                for(let author in authors)
                {
                    if (author == 0)
                    {
                        _author += authors[author];
                        continue;
                    }

                    if (authors.length - 1 == author)
                    {
                        _author += ' и ' + authors[author];
                        break;
                    }

                    _author += ', ' + authors[author];
                }

                return _author;
            },
            openBookInfoBlock: function () {

                if (this.bookInfoState)
                    return;

                document.body.classList.add('blockScroll');

                //Создание копии обложки для перемещения
                var _book = Vue.extend(MovingBookCover);
                this.movingBook = new _book();
                this.movingBook.param = this.book;
                this.movingBook.$mount();

                this.bookInfoState = true;
                this.openedBookId = this.book.book_id;

                var cover = this.movingBook.$el;

                document.getElementById('app').appendChild(cover);

                cover.style.top = this.book.position.y + 'px';
                cover.style.left = this.book.position.x + 'px';
                cover.style.transform = "translate(0px, 0px)";

                this.bookInfoMounted();
            },
            closeBookInfoBlock: function () {
                document.body.classList.remove('blockScroll');

                this.shifts.x = 0; this.shifts.y = 0;
                this.movingBook.$destroy();
                this.movingBook = null;
                var books = document.getElementsByClassName('book hide');

                while (books.length) books[0].classList.remove('hide');
            },
            bookInfoMounted: function () {
                var coverPlase = document.getElementById('book-info').getElementsByClassName('book-cover')[0];
                var cover = document.getElementsByClassName('moving-book-cover')[0];

                var coverPlacePositionInBookinfo = coverPlase.getBoundingClientRect();
                var coverCurrentPosition = cover.getBoundingClientRect();

                cover.style.backgroundImage = "url('" + this.movingBook.param.image + "')";

                var shiftX = Math.abs(coverPlacePositionInBookinfo.x - coverCurrentPosition.x);
                shiftX = (coverCurrentPosition.x > coverPlacePositionInBookinfo.x) ? (shiftX * -1) : shiftX;

                var coverPlaceY = (coverPlacePositionInBookinfo.y - window.innerHeight);
                var shiftY = Math.abs(coverPlaceY - coverCurrentPosition.y);
                shiftY = (coverPlaceY < coverCurrentPosition.y) ? (shiftY * -1) : shiftY;

                this.shifts.size_x = coverCurrentPosition.width;
                this.shifts.size_y = coverCurrentPosition.height;

                this.tween(shiftX, shiftY, coverPlacePositionInBookinfo.width, coverPlacePositionInBookinfo.height, 10);

                setTimeout(() => {
                    coverPlase.appendChild(cover);
                    cover.style.position = "relative";
                    cover.style.top = "0px";
                    cover.style.left = "0px";
                    cover.style.transform = "translate(0px, 0px)";
                }, 450);

            },
            tween: function (_x, _y, _size_x, _size_y, _radius) {
                function animate () {
                    if (TWEEN.update()) {
                        requestAnimationFrame(animate);
                    }
                }

                var vm = this;

                new TWEEN.Tween( vm.shifts )
                    .to({ x: _x, y: _y, size_x: _size_x, size_y: _size_y, radius: _radius }, 400)
                    .easing(TWEEN.Easing.Quadratic.Out)
                    .onUpdate(function () {
                        vm.movingBook.$el.style.transform = "translate(" + vm.shifts.x + "px, " + vm.shifts.y + "px)";
                        vm.movingBook.$el.style.width = vm.shifts.size_x + 'px';
                        vm.movingBook.$el.style.height = vm.shifts.size_y + 'px';
                        vm.movingBook.$el.style.borderRadius = vm.shifts.radius + 'px';
                    })
                    .start();

                animate();
            },
        },
        mounted: function () {

            this.openBookInfoBlock();

            if (isNaN(this.book.book_id))
            {
                this.$emit('error-open-book-info');
                return;
            }

            axios
                .post('/api/book/getinfo', {
                    book_id: this.book.book_id
                })
                .then(response => (this.book_info = response.data));


        }
    }

</script>
