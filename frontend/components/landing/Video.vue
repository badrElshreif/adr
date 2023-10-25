<template>
  <section class="video-section">
    <div class="video-container">
      <video
        autoplay
        loop
        muted
        class="video-background"
        src="http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerEscapes.mp4"
      ></video>
    </div>
    <div class="video-layout"></div>
    <div class="text-container">
      <p class="section-description"> {{ $t("front.video") }}</p>
      <b-button v-b-modal.modal-1 class="bg-transparent border-0">
        <img src="~/assets/new-imgs/landing/play.svg" alt=""
      /></b-button>

      <b-modal id="modal-1" hide-footer hide-header>
        <video
          autoplay
          loop
          src="http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerEscapes.mp4"
          controls
        ></video>
      </b-modal>
    </div>
  </section>
</template>

<script>
export default {};
</script>

<style scoped>
.video-section {
  position: relative;
  height: 50vh;
  overflow: hidden;
  /* margin-top: 50px; */
  z-index: 2;
}

.video-container {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: -1;
  overflow: hidden;
}
 video {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
.video-layout {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: -1;
  overflow: hidden;
  opacity: 0.6;
  background: var(--Secondry, #171717);
}

.video-background {
  min-width: 100%;
  min-height: 100%;
  /* object-fit: cover; */
}

.text-container {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
  color: #ffffff;
}

.section-description {
  font-size: 1.5rem;
  margin-bottom: 1rem;
}
</style>
