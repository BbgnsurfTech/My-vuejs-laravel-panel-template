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
                <strong>{{ $t('cruds.crmNote.title_singular') }}</strong>
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
                      'has-items': entry.customer_id !== null,
                      'is-focused': activeField == 'customer'
                    }"
                  >
                    <label class="bmd-label-floating required">{{
                      $t('cruds.crmNote.fields.customer')
                    }}</label>
                    <v-select
                      name="customer"
                      label="first_name"
                      :key="'customer-field'"
                      :value="entry.customer_id"
                      :options="lists.customer"
                      :reduce="entry => entry.id"
                      @input="updateCustomer"
                      @search.focus="focusField('customer')"
                      @search.blur="clearFocus"
                    />
                  </div>
                  <div
                    class="form-group bmd-form-group"
                    :class="{
                      'has-items': entry.note,
                      'is-focused': activeField == 'note'
                    }"
                  >
                    <label class="bmd-label-floating required">{{
                      $t('cruds.crmNote.fields.note')
                    }}</label>
                    <textarea
                      class="form-control"
                      rows="5"
                      :value="entry.note"
                      @input="updateNote"
                      @focus="focusField('note')"
                      @blur="clearFocus"
                      required
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
    ...mapGetters('CrmNotesSingle', ['entry', 'loading', 'lists'])
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
    ...mapActions('CrmNotesSingle', [
      'fetchEditData',
      'updateData',
      'resetState',
      'setCustomer',
      'setNote'
    ]),
    updateCustomer(value) {
      this.setCustomer(value)
    },
    updateNote(e) {
      this.setNote(e.target.value)
    },
    submitForm() {
      this.updateData()
        .then(() => {
          this.$router.push({ name: 'crm_notes.index' })
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
