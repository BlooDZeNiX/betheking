<template>
  <!-- component -->
<div>
      <section class="text-gray-700">
        <div class="container px-5 py-24 mx-auto">
          <div class="text-center mb-20">
            <h1 class="sm:text-3xl text-2xl font-medium text-center title-font text-gray-900 mb-4">
              Frequently Asked Question
            </h1>
            <p class="text-base leading-relaxed xl:w-2/4 lg:w-3/4 mx-auto">
              The most common questions about BeTheKing are here!
            </p>
          </div>
          <div class="flex flex-wrap lg:w-4/5 sm:mx-auto sm:mb-2 -mx-2">
            <div class="w-full lg:w-1/2 px-4 py-2">
              <details class="mb-4">
                <summary class="font-semibold  bg-gray-200 rounded-md py-2 px-4">
                  How do I change my profile image and other data?
                </summary>

                <span>
                  Click on your profile image on top right of the website, then profile.
                  Now you have to click on edit.
                </span>
              </details>
              <details class="mb-4">
                <summary class="font-semibold bg-gray-200 rounded-md py-2 px-4">
                  How can I vote a King?
                </summary>

                <span>
                  Go to Streamers or Games tab, select your King.
                  Click on vote and watch the ads, now you got this.
                </span>
              </details>
              <details class="mb-4">
                <summary class="font-semibold  bg-gray-200 rounded-md py-2 px-4">
                  How much times can I vote a King?
                </summary>

                <span>
                  You can vote Games and Streamers each hour, both each hour.
                </span>
              </details>
            </div>
            <div class="w-full lg:w-1/2 px-4 py-2">
              <details class="mb-4">
                <summary class="font-semibold  bg-gray-200 rounded-md py-2 px-4">
                  What are Gold for?
                </summary>

                <span class="px-4 py-2">
                  When you vote, you'll get Gold, you can exchange it for a Twitch Suscription, if you have enough Gold for the exchange.
                </span>
              </details>
              <details class="mb-4">
                <summary class="font-semibold  bg-gray-200 rounded-md py-2 px-4">
                  Where is you privacy policy?
                </summary>

                <span class="px-4 py-2">
                  You can read it by clicking in "Privacy Policy" in the bottom of the website.
                </span>
              </details>
              <details class="mb-4">
                <summary class="font-semibold  bg-gray-200 rounded-md py-2 px-4">
                  How can I communicate with you?
                </summary>

                <span class="px-4 py-2">
                  Just click on "Contact us" in the bottom of the website, and fill the formulary.
                </span>
              </details>
            </div>
          </div>
        </div>
      </section>
    </div>
</template>

<style scoped>
details[open] summary{
  background-color: teal;
  color: white;
}
</style>

<script>
export default {
  name: "FAQ",
  data: function () {
    return {

    };
  },
  components: {},
  methods: {

  },
  mounted() {

  },
};
</script>
