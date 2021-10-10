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
                <strong>{{ $t('cruds.faqQuestion.title_singular') }}</strong>
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
                      'has-items': entry.category_id !== null,
                      'is-focused': activeField == 'category'
                    }"
                  >
                    <label class="bmd-label-floating required">{{
                      $t('cruds.faqQuestion.fields.category')
                    }}</label>
                    <v-select
                      name="category"
                      label="category"
                      :key="'category-field'"
                      :value="entry.category_id"
                      :options="lists.category"
                      :reduce="entry => entry.id"
                      @input="updateCategory"
                      @search.focus="focusField('category')"
                      @search.blur="clearFocus"
                    />
                  </div>
                  <div
                    class="form-group bmd-form-group"
                    :class="{
                      'has-items': entry.question,
                      'is-focused': activeField == 'question'
                    }"
                  >
                    <label class="bmd-label-floating required">{{
                      $t('cruds.faqQuestion.fields.question')
                    }}</label>
                    <textarea
                      class="form-control"
                      rows="5"
                      :value="entry.question"
                      @input="updateQuestion"
                      @focus="focusField('question')"
                      @blur="clearFocus"
                      required
                    ></textarea>
                  </div>
                  <div
                    class="form-group bmd-form-group"
                    :class="{
                      'has-items': entry.answer,
                      'is-focused': activeField == 'answer'
                    }"
                  >
                    <label class="bmd-label-floating required">{{
                      $t('cruds.faqQuestion.fields.answer')
                    }}</label>
                    <textarea
                      class="form-control"
                      rows="5"
                      :value="entry.answer"
                      @input="updateAnswer"
                      @focus="focusField('answer')"
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
    ...mapGetters('FaqQuestionsSingle', ['entry', 'loading', 'lists'])
  },
  mounted() {
    this.fetchCreateData()
  },
  beforeDestroy() {
    this.resetState()
  },
  methods: {
    ...mapActions('FaqQuestionsSingle', [
      'storeData',
      'resetState',
      'setCategory',
      'setQuestion',
      'setAnswer',
      'fetchCreateData'
    ]),
    updateCategory(value) {
      this.setCategory(value)
    },
    updateQuestion(e) {
      this.setQuestion(e.target.value)
    },
    updateAnswer(e) {
      this.setAnswer(e.target.value)
    },
    submitForm() {
      this.storeData()
        .then(() => {
          this.$router.push({ name: 'faq_questions.index' })
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
