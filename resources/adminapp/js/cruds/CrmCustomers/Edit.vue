<template>
  <div class="container-fluid">
    <form @submit.prevent="submitForm">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary card-header-icon">
              <div class="card-icon">
                <i class="material-icons">edit</i>
              </div>
              <h4 class="card-title">
                {{ $t('global.edit') }}
                <strong>{{ $t('cruds.crmCustomer.title_singular') }}</strong>
              </h4>
            </div>
            <div class="card-body">
              <back-button></back-button>
            </div>
            <div class="card-body">
              <bootstrap-alert />
              <div class="row">
                <div class="col-md-12">
                  <div
                    class="form-group bmd-form-group"
                    :class="{
                      'has-items': entry.first_name,
                      'is-focused': activeField == 'first_name'
                    }"
                  >
                    <label class="bmd-label-floating required">{{
                      $t('cruds.crmCustomer.fields.first_name')
                    }}</label>
                    <input
                      class="form-control"
                      type="text"
                      :value="entry.first_name"
                      @input="updateFirstName"
                      @focus="focusField('first_name')"
                      @blur="clearFocus"
                      required
                    />
                  </div>
                  <div
                    class="form-group bmd-form-group"
                    :class="{
                      'has-items': entry.last_name,
                      'is-focused': activeField == 'last_name'
                    }"
                  >
                    <label class="bmd-label-floating required">{{
                      $t('cruds.crmCustomer.fields.last_name')
                    }}</label>
                    <input
                      class="form-control"
                      type="text"
                      :value="entry.last_name"
                      @input="updateLastName"
                      @focus="focusField('last_name')"
                      @blur="clearFocus"
                      required
                    />
                  </div>
                  <div
                    class="form-group bmd-form-group"
                    :class="{
                      'has-items': entry.status_id !== null,
                      'is-focused': activeField == 'status'
                    }"
                  >
                    <label class="bmd-label-floating required">{{
                      $t('cruds.crmCustomer.fields.status')
                    }}</label>
                    <v-select
                      name="status"
                      label="name"
                      :key="'status-field'"
                      :value="entry.status_id"
                      :options="lists.status"
                      :reduce="entry => entry.id"
                      @input="updateStatus"
                      @search.focus="focusField('status')"
                      @search.blur="clearFocus"
                    />
                  </div>
                  <div
                    class="form-group bmd-form-group"
                    :class="{
                      'has-items': entry.email,
                      'is-focused': activeField == 'email'
                    }"
                  >
                    <label class="bmd-label-floating">{{
                      $t('cruds.crmCustomer.fields.email')
                    }}</label>
                    <input
                      class="form-control"
                      type="text"
                      :value="entry.email"
                      @input="updateEmail"
                      @focus="focusField('email')"
                      @blur="clearFocus"
                    />
                  </div>
                  <div
                    class="form-group bmd-form-group"
                    :class="{
                      'has-items': entry.phone,
                      'is-focused': activeField == 'phone'
                    }"
                  >
                    <label class="bmd-label-floating">{{
                      $t('cruds.crmCustomer.fields.phone')
                    }}</label>
                    <input
                      class="form-control"
                      type="text"
                      :value="entry.phone"
                      @input="updatePhone"
                      @focus="focusField('phone')"
                      @blur="clearFocus"
                    />
                  </div>
                  <div
                    class="form-group bmd-form-group"
                    :class="{
                      'has-items': entry.address,
                      'is-focused': activeField == 'address'
                    }"
                  >
                    <label class="bmd-label-floating">{{
                      $t('cruds.crmCustomer.fields.address')
                    }}</label>
                    <input
                      class="form-control"
                      type="text"
                      :value="entry.address"
                      @input="updateAddress"
                      @focus="focusField('address')"
                      @blur="clearFocus"
                    />
                  </div>
                  <div
                    class="form-group bmd-form-group"
                    :class="{
                      'has-items': entry.skype,
                      'is-focused': activeField == 'skype'
                    }"
                  >
                    <label class="bmd-label-floating">{{
                      $t('cruds.crmCustomer.fields.skype')
                    }}</label>
                    <input
                      class="form-control"
                      type="text"
                      :value="entry.skype"
                      @input="updateSkype"
                      @focus="focusField('skype')"
                      @blur="clearFocus"
                    />
                  </div>
                  <div
                    class="form-group bmd-form-group"
                    :class="{
                      'has-items': entry.website,
                      'is-focused': activeField == 'website'
                    }"
                  >
                    <label class="bmd-label-floating">{{
                      $t('cruds.crmCustomer.fields.website')
                    }}</label>
                    <input
                      class="form-control"
                      type="text"
                      :value="entry.website"
                      @input="updateWebsite"
                      @focus="focusField('website')"
                      @blur="clearFocus"
                    />
                  </div>
                  <div
                    class="form-group bmd-form-group"
                    :class="{
                      'has-items': entry.description,
                      'is-focused': activeField == 'description'
                    }"
                  >
                    <label class="bmd-label-floating">{{
                      $t('cruds.crmCustomer.fields.description')
                    }}</label>
                    <textarea
                      class="form-control"
                      rows="5"
                      :value="entry.description"
                      @input="updateDescription"
                      @focus="focusField('description')"
                      @blur="clearFocus"
                    ></textarea>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <vue-button-spinner
                class="btn-primary"
                :status="status"
                :isLoading="loading"
                :disabled="loading"
              >
                {{ $t('global.save') }}
              </vue-button-spinner>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  data() {
    return {
      status: '',
      activeField: ''
    }
  },
  computed: {
    ...mapGetters('CrmCustomersSingle', ['entry', 'loading', 'lists'])
  },
  beforeDestroy() {
    this.resetState()
  },
  watch: {
    '$route.params.id': {
      immediate: true,
      handler() {
        this.resetState()
        this.fetchEditData(this.$route.params.id)
      }
    }
  },
  methods: {
    ...mapActions('CrmCustomersSingle', [
      'fetchEditData',
      'updateData',
      'resetState',
      'setFirstName',
      'setLastName',
      'setStatus',
      'setEmail',
      'setPhone',
      'setAddress',
      'setSkype',
      'setWebsite',
      'setDescription'
    ]),
    updateFirstName(e) {
      this.setFirstName(e.target.value)
    },
    updateLastName(e) {
      this.setLastName(e.target.value)
    },
    updateStatus(value) {
      this.setStatus(value)
    },
    updateEmail(e) {
      this.setEmail(e.target.value)
    },
    updatePhone(e) {
      this.setPhone(e.target.value)
    },
    updateAddress(e) {
      this.setAddress(e.target.value)
    },
    updateSkype(e) {
      this.setSkype(e.target.value)
    },
    updateWebsite(e) {
      this.setWebsite(e.target.value)
    },
    updateDescription(e) {
      this.setDescription(e.target.value)
    },
    submitForm() {
      this.updateData()
        .then(() => {
          this.$router.push({ name: 'crm_customers.index' })
          this.$eventHub.$emit('update-success')
        })
        .catch(error => {
          this.status = 'failed'
          _.delay(() => {
            this.status = ''
          }, 3000)
        })
    },
    focusField(name) {
      this.activeField = name
    },
    clearFocus() {
      this.activeField = ''
    }
  }
}
</script>
