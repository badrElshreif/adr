<template>
  <div class="card_db_wrapper">
    <title-bar :title-stack="titleStack" />

    <section class="section is-main-section">
      <card-component :title="titlePage" icon="fas fa-clipboard-list 5x">
        <b-row>
          <b-col lg="6">
            <p><span style="color:green;">{{$t('admin.name') + ' : '}} </span> {{ item.name || '' }}</p>
            <p><span style="color:green;">{{$t('admin.phone') + ' : '}}</span> {{ item.phone || '' }}</p>
            <p><span style="color:green;">{{$t('admin.email') + ' : '}}</span> {{ item.email || '' }}</p>
            <p><span style="color:green;">{{$t('admin.roles') + ' : ' }}</span>
            <ul>
              <li v-for="(role,index) in item.roles" :key="index">
                {{role.display_name}}
              </li>
            </ul>
            </p>
          </b-col>
        </b-row>
      </card-component>
    </section>
  </div>

</template>

<script src="./index.js"></script>
