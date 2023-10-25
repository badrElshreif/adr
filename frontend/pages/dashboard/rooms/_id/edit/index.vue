<template>
  <div class="card_db_wrapper">
    <title-bar :title-stack="titleStack" />

    <section class="section is-main-section">
      <card-component :title="titlePage" icon="fas fa-clipboard-list 5x">
        <formData :item="item" :itemType="`global`" />
      </card-component>
    </section>
  </div>
</template>

<script src="./index.js"></script>
