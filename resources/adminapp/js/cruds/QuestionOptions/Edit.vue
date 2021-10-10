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
                <strong>{{ $t('cruds.questionOption.title_singular') }}</strong>
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
                      'has-items': entry.question_id !== null,
                      'is-focused': activeField == 'question'
                    }"
                  >
                    <label class="bmd-label-floating">{{
                      $t('cruds.questionOption.fields.question')
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
                      'has-items': entry.option_text,
                      'is-focused': activeField == 'option_text'
                    }"
                  >
                    <label class="bmd-label-floating required">{{
                      $t('cruds.questionOption.fields.option_text')
                    }}</label>
                    <input
                      class="form-control"
                      type="text"
                      :value="entry.option_text"
                      @input="updateOptionText"
                      @focus="focusField('option_text')"
                      @blur="clearFocus"
                      required
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
                      >{{ $t('cruds.questionOption.fields.is_correct') }}</label
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
    ...mapGetters('QuestionOptionsSingle', ['entry', 'loading', 'lists'])
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
    ...mapActions('QuestionOptionsSingle', [
      'fetchEditData',
      'updateData',
      'resetState',
      'setQuestion',
      'setOptionText',
      'setIsCorrect'
    ]),
    updateQuestion(value) {
      this.setQuestion(value)
    },
    updateOptionText(e) {
      this.setOptionText(e.target.value)
    },
    updateIsCorrect(e) {
      this.setIsCorrect(e.target.checked)
    },
    submitForm() {
      this.updateData()
        .then(() => {
          this.$router.push({ name: 'question_options.index' })
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
