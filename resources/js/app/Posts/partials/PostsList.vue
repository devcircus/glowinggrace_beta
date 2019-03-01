<template>
    <div>
        <transition-group v-if="postsAvailable" name="slide-slow" class="mb-8 flex flex-col flex-wrap items-center" tag="div">
            <div v-for="item in infiniteData" :key="item.id" class="flex flex-col w-full md:w-4/5 xl:w-3/5 h-auto bg-white shadow-md rounded-lg px-4 pt-4 pb-8 mb-4 overflow-hidden">
                <div class="w-full h-auto rounded-t overflow-hidden mb-2">
                    <img :data-src="getFeaturedImage(item)" class="w-full h-auto cld-responsive" :ref="`featured_image_${item.id}`"/>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-grey-darker text-sm ml-auto mr-2">{{ formattedAgoDate(item.published_at) }}</span>
                    <span class="text-grey-dark text-sm mr-2">by {{ item.user.name }}</span>
                    <img class="w-8 h-8 rounded-full" :src="item.user.avatar" :alt="`Avatar of ${item.user.name }`">
                </div>
                <div class="flex flex-col bg-white rounded-b leading-normal">
                    <div class="text-xl text-black font-bold mb-2">{{ item.title }}</div>
                    <p class="text-base text-grey-darker mb-2">{{ item.summary }}</p>
                    <router-link :to="{ name: 'show-post', params: { postId: item.id }}" class="view-post text-grey-darkest font-semibold no-underline py-2 ml-auto mr-2 active-none">
                        <span class="inline-block uppercase text-sm text-grey-darker uppercase font-semibold">View Post</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 icon-cheveron-right-circle inline-block align-middle"><circle cx="12" cy="12" r="10" class="primary"></circle><path class="secondary" d="M10.3 8.7a1 1 0 0 1 1.4-1.4l4 4a1 1 0 0 1 0 1.4l-4 4a1 1 0 0 1-1.4-1.4l3.29-3.3-3.3-3.3z"></path></svg>
                    </router-link>
                </div>
            </div>
        </transition-group>
        <span v-if="error" class="label label-danger">Error loading list.</span>
        <span v-if="posts && display < numberOfPosts()" class="load-more absolute cursor-pointer text-grey-darker font-semibold py-2">Scroll for more posts...</span>
        <div v-if="postsNotAvailable && loading" class="w-full mt-200p">
            <div class="load-1 w-3/5 mx-auto text-center">
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
            </div>
        </div>
        <h2 v-if="postsNotAvailable && ! loading" class="text-lg text-blue font-normal uppercase">No Published Posts</h2>
    </div>
</template>

<script>
    import Posts from 'Mixins/Posts';
    import { debounce } from 'lodash';
    const imagesLoaded = require('imagesloaded');
    import RandomImage from 'Libraries/RandomImage';

    export default {
        mixins: [ Posts ],
        data () {
            return {
                imageGenerator: new RandomImage(),
                cloud: null,
                width: 0,
                display: 0,
                offset: 3,
                bottom: false,
                error: false,
            }
        },
        computed: {
            infiniteData () {
                return this.display > 0 ? this.posts.slice(0 ,this.display) : [];
            },
            morePosts () {
                return this.posts && this.display < this.posts.length;
            }
        },
        watch: {
            bottom (bottom) {
                if (bottom) {
                    this.addRowOfPosts()
                }
            }
        },
        created () {
            this.getPostsIfNoneAvailable();
            this.setCloudinary();
            this.setEventListeners();
            this.setInitialScreenWidth();
        },
        mounted () {
            this.addInitialRowOfPosts();
        },
        updated () {
            this.getResponsiveImages();
        },
        methods: {
            getPostsIfNoneAvailable () {
                if (this.postsNotAvailable) {
                    this.getPosts();
                }
            },
            addInitialRowOfPosts () {
                window.setTimeout( () => {
                    this.addRowOfPosts();
                    this.getResponsiveImages();
                }, 750);
            },
            setCloudinary () {
                /* global cloudinary */
                this.cloud = cloudinary.Cloudinary.new({
                    cloud_name: 'phpstage'
                });
            },
            setEventListeners () {
                this.setScrollListener();
                this.setWindowResizeListener();
            },
            setScrollListener () {
                window.addEventListener('scroll', this.checkIfBottomVisible);
            },
            checkIfBottomVisible () {
                this.bottom = this.bottomVisible();
            },
            setWindowResizeListener () {
                window.addEventListener('resize', debounce(this.handleWindowResize, 200));
            },
            setInitialScreenWidth () {
                this.width = window.innerWidth;
            },
            getFeaturedImage (post) {
                return post.featured_image ? post.featured_image.full_size_url : this.imageGenerator.getImage();
            },
            getResponsiveImages () {
                this.$nextTick( () => {
                    imagesLoaded('#posts-container', () => {
                        this.cloud.responsive();
                    });
                });
            },
            handleWindowResize (e) {
                if (this.windowResizeRequiresImageRefresh()) {
                    this.cloud.responsive();
                    this.width = window.innerWidth;
                }
            },
            windowResizeRequiresImageRefresh () {
                return (this.width >= 1200 && window.innerWidth < 1200) ||
                    (this.width >= 992 && window.innerWidth < 992) ||
                    (this.width >= 768 && window.innerWidth < 768) ||
                    (this.width >= 576 && window.innerWidth < 576) ||
                    (this.width <= 575 && window.innerWidth > 575) ||
                    (this.width <= 767 && window.innerWidth > 767) ||
                    (this.width <= 991 && window.innerWidth > 991) ||
                    (this.width <= 1199 && window.innerWidth > 1199);
            },
            addRowOfPosts () {
                this.display = this.display + this.offset;
            },
            bottomVisible () {
                const scrollY = window.scrollY;
                const visible = document.documentElement.clientHeight;
                const pageHeight = document.documentElement.scrollHeight;
                const bottomOfPage = visible + scrollY >= pageHeight;

                return bottomOfPage || pageHeight < visible;
            }
        }
    }
</script>

<style>

</style>