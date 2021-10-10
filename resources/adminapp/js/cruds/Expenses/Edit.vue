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
                <strong>{{ $t('cruds.expense.title_singular') }}</strong>
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
                      'has-items': entry.expense_category_id !== null,
                      'is-focused': activeField == 'expense_category'
                    }"
                  >
                    <label class="bmd-label-floating">{{
                      $t('cruds.expense.fields.expense_category')
                    }}</label>
                    <v-select
                      name="expense_category"
                      label="name"
                      :key="'expense_category-field'"
                      :value="entry.expense_category_id"
                      :options="lists.expense_category"
                      :reduce="entry => entry.id"
                      @input="updateExpenseCategory"
                      @search.focus="focusField('expense_category')"
                      @search.blur="clearFocus"
                    />
                  </div>
                  <div
                    class="form-group bmd-form-group"
                    :class="{
                      'has-items': entry.entry_date,
                      'is-focused': activeField == 'entry_date'
                    }"
                  >
                    <label class="bmd-label-floating required">{{
                      $t('cruds.expense.fields.entry_date')
                    }}</label>
                    <datetime-picker
                      class="form-control"
                      type="text"
                      picker="date"
                      :value="entry.entry_date"
                      @input="updateEntryDate"
                      @focus="focusField('entry_date')"
                      @blur="clearFocus"
                      required
                    >
                    </datetime-picker>
                  </div>
                  <div
                    class="form-group bmd-form-group"
                    :class="{
                      'has-items': entry.amount,
                      'is-focused': activeField == 'amount'
                    }"
                  >
                    <label class="bmd-label-floating required">{{
                      $t('cruds.expense.fields.amount')
                    }}</label>
                    <input
                      class="form-control"
                      type="number"
                      step="0.01"
                      :value="entry.amount"
                      @input="updateAmount"
                      @focus="focusField('amount')"
                      @blur="clearFocus"
                      required
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
                      $t('cruds.expense.fields.description')
                    }}</label>
                    <input
                      class="form-control"
                      type="text"
                      :value="entry.description"
                      @input="updateDescription"
                      @focus="focusField('description')"
                      @blur="clearFocus"
                    />
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
    ...mapGetters('ExpensesSingle', ['entry', 'loading', 'lists'])
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
    ...mapActions('ExpensesSingle', [
      'fetchEditData',
      'updateData',
      'resetState',
      'setExpenseCategory',
      'setEntryDate',
      'setAmount',
      'setDescription'
    ]),
    updateExpenseCategory(value) {
      this.setExpenseCategory(value)
    },
    updateEntryDate(e) {
      this.setEntryDate(e.target.value)
    },
    updateAmount(e) {
      this.setAmount(e.target.value)
    },
    updateDescription(e) {
      this.setDescription(e.target.value)
    },
    submitForm() {
      this.updateData()
        .then(() => {
          this.$router.push({ name: 'expenses.index' })
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
