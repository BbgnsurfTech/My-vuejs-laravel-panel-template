<template>
  <div class="container-fluid">
    <form @submit.prevent="submitForm">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary card-header-icon">
              <div class="card-icon">
                <i class="material-icons">add</i>
              </div>
              <h4 class="card-title">
                {{ $t('global.create') }}
                <strong>{{ $t('cruds.testResult.title_singular') }}</strong>
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
                      'has-items': entry.test_id !== null,
                      'is-focused': activeField == 'test'
                    }"
                  >
                    <label class="bmd-label-floating">{{
                      $t('cruds.testResult.fields.test')
                    }}</label>
                    <v-select
                      name="test"
                      label="title"
                      :key="'test-field'"
                      :value="entry.test_id"
                      :options="lists.test"
                      :reduce="entry => entry.id"
                      @input="updateTest"
                      @search.focus="focusField('test')"
                      @search.blur="clearFocus"
                    />
                  </div>
                  <div
                    class="form-group bmd-form-group"
                    :class="{
                      'has-items': entry.student_id !== null,
                      'is-focused': activeField == 'student'
                    }"
                  >
                    <label class="bmd-label-floating required">{{
                      $t('cruds.testResult.fields.student')
                    }}</label>
                    <v-select
                      name="student"
                      label="name"
                      :key="'student-field'"
                      :value="entry.student_id"
                      :options="lists.student"
                      :reduce="entry => entry.id"
                      @input="updateStudent"
                      @search.focus="focusField('student')"
                      @search.blur="clearFocus"
                    />
                  </div>
                  <div
                    class="form-group bmd-form-group"
                    :class="{
                      'has-items': entry.score,
                      'is-focused': activeField == 'score'
                    }"
                  >
                    <label class="bmd-label-floating">{{
                      $t('cruds.testResult.fields.score')
                    }}</label>
                    <input
                      class="form-control"
                      type="number"
                      step="1"
                      :value="entry.score"
                      @input="updateScore"
                      @focus="focusField('score')"
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
    ...mapGetters('TestResultsSingle', ['entry', 'loading', 'lists'])
  },
  mounted() {
    this.fetchCreateData()
  },
  beforeDestroy() {
    this.resetState()
  },
  methods: {
    ...mapActions('TestResultsSingle', [
      'storeData',
      'resetState',
      'setTest',
      'setStudent',
      'setScore',
      'fetchCreateData'
    ]),
    updateTest(value) {
      this.setTest(value)
    },
    updateStudent(value) {
      this.setStudent(value)
    },
    updateScore(e) {
      this.setScore(e.target.value)
    },
    submitForm() {
      this.storeData()
        .then(() => {
          this.$router.push({ name: 'test_results.index' })
          this.$eventHub.$emit('create-success')
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
