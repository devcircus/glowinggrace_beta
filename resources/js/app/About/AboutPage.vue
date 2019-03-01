<template>
    <div class="flex flex-col w-full -ml-2 mb-4">
        <h1 class="post-title text-4xl mb-2 font-normal text-grey-darkest uppercase">A Little About Me</h1>
        <div class="stripe p-12 xl:p-20">
            <div class="stripe__content flex flex-col lg:flex-row justify-between">
                <div class="w-full lg:w-1/4 mr-4">
                    <img :src="image" class="w-3/5 lg:w-full rounded-lg shadow-md border-2 border-white lg:mr-0" />
                </div>
                <div class="w-full lg:w-3/4">
                    <p class="text-green-lightest text-2xl lg:mt-4">
                        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                image: null,
            }
        },
        created () {
            this.image = "https://res.cloudinary.com/phpstage/image/upload/f_auto,e_auto_contrast,r_0,w_auto,q_auto/v1551147038/IMG_0003.jpg";
        }
    }
</script>