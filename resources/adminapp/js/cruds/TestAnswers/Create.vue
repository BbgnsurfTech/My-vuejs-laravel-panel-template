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
                <strong>{{ $t('cruds.testAnswer.title_singular') }}</strong>
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
                      'has-items': entry.test_result_id !== null,
                      'is-focused': activeField == 'test_result'
                    }"
                  >
                    <label class="bmd-label-floating required">{{
                      $t('cruds.testAnswer.fields.test_result')
                    }}</label>
                    <v-select
                      name="test_result"
                      label="score"
                      :key="'test_result-field'"
                      :value="entry.test_result_id"
                      :options="lists.test_result"
                      :reduce="entry => entry.id"
                      @input="updateTestResult"
                      @search.focus="focusField('test_result')"
                      @search.blur="clearFocus"
                    />
                  </div>
                  <div
                    class="form-group bmd-form-group"
                    :class="{
                      'has-items': entry.question_id !== null,
                      'is-focused': activeField == 'question'
                    }"
                  >
                    <label class="bmd-label-floating required">{{
                      $t('cruds.testAnswer.fields.question')
                    }}</label>
                    <v-select
                      name="question"
                      label="question_text"
                      :key="'question-field'"
                      :value="entry.question_id"
                      :options="lists.question"
                      :reduce="entry => entry.id"
                      @input="updateQuestion"
                      @search.focus="focusField('question')"
                      @search.blur="clearFocus"
                    />
                  </div>
                  <div
                    class="form-group bmd-form-group"
                    :class="{
                      'has-items': entry.option_id !== null,
                      'is-focused': activeField == 'option'
                    }"
                  >
                    <label class="bmd-label-floating required">{{
                      $t('cruds.testAnswer.fields.option')
                    }}</label>
                    <v-select
                      name="option"
                      label="option_text"
                      :key="'option-field'"
                      :value="entry.option_id"
                      :options="lists.option"
                      :reduce="entry => entry.id"
                      @input="updateOption"
                      @search.focus="focusField('option')"
                      @search.blur="clearFocus"
                    />
                  </div>
                  <div class="form-group form-check">
                    <label class="form-check-label"
                      ><input
                        class="form-check-input"
                        type="checkbox"
                        :value="entry.is_correct"
                        :checked="entry.is_correct"
                        @change="updateIsCorrect"
                      /><span class="form-check-sign"
                        ><span class="check"></span></span
                      >{{ $t('cruds.testAnswer.fields.is_correct') }}</label
                    >
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
    ...mapGetters('TestAnswersSingle', ['entry', 'loading', 'lists'])
  },
  mounted() {
    this.fetchCreateData()
  },
  beforeDestroy() {
    this.resetState()
  },
  methods: {
    ...mapActions('TestAnswersSingle', [
      'storeData',
      'resetState',
      'setTestResult',
      'setQuestion',
      'setOption',
      'setIsCorrect',
      'fetchCreateData'
    ]),
    updateTestResult(value) {
      this.setTestResult(value)
    },
    updateQuestion(value) {
      this.setQuestion(value)
    },
    updateOption(value) {
      this.setOption(value)
    },
    updateIsCorrect(e) {
      this.setIsCorrect(e.target.checked)
    },
    submitForm() {
      this.storeData()
        .then(() => {
          this.$router.push({ name: 'test_answers.index' })
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
