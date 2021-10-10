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
                <strong>{{ $t('cruds.question.title_singular') }}</strong>
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
                      'has-items': entry.course_id !== null,
                      'is-focused': activeField == 'course'
                    }"
                  >
                    <label class="bmd-label-floating">{{
                      $t('cruds.question.fields.course')
                    }}</label>
                    <v-select
                      name="course"
                      label="title"
                      :key="'course-field'"
                      :value="entry.course_id"
                      :options="lists.course"
                      :reduce="entry => entry.id"
                      @input="updateCourse"
                      @search.focus="focusField('course')"
                      @search.blur="clearFocus"
                    />
                  </div>
                  <div
                    class="form-group bmd-form-group"
                    :class="{
                      'has-items': entry.question_text,
                      'is-focused': activeField == 'question_text'
                    }"
                  >
                    <label class="bmd-label-floating required">{{
                      $t('cruds.question.fields.question_text')
                    }}</label>
                    <input
                      class="form-control"
                      type="text"
                      :value="entry.question_text"
                      @input="updateQuestionText"
                      @focus="focusField('question_text')"
                      @blur="clearFocus"
                      required
                    />
                  </div>
                  <div class="form-group">
                    <label>{{
                      $t('cruds.question.fields.question_image')
                    }}</label>
                    <attachment
                      :route="getRoute('questions')"
                      :collection-name="'question_question_image'"
                      :media="entry.question_image"
                      :max-file-size="2"
                      :component="'pictures'"
                      :accept="'image/*'"
                      @file-uploaded="insertQuestionImageFile"
                      @file-removed="removeQuestionImageFile"
                      :max-files="1"
                    />
                  </div>
                  <div
                    class="form-group bmd-form-group"
                    :class="{
                      'has-items': entry.points,
                      'is-focused': activeField == 'points'
                    }"
                  >
                    <label class="bmd-label-floating">{{
                      $t('cruds.question.fields.points')
                    }}</label>
                    <input
                      class="form-control"
                      type="number"
                      step="1"
                      :value="entry.points"
                      @input="updatePoints"
                      @focus="focusField('points')"
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
import Attachment from '@components/Attachments/Attachment'

export default {
  components: {
    Attachment
  },
  data() {
    return {
      status: '',
      activeField: ''
    }
  },
  computed: {
    ...mapGetters('QuestionsSingle', ['entry', 'loading', 'lists'])
  },
  mounted() {
    this.fetchCreateData()
  },
  beforeDestroy() {
    this.resetState()
  },
  methods: {
    ...mapActions('QuestionsSingle', [
      'storeData',
      'resetState',
      'setCourse',
      'setQuestionText',
      'insertQuestionImageFile',
      'removeQuestionImageFile',
      'setPoints',
      'fetchCreateData'
    ]),
    updateCourse(value) {
      this.setCourse(value)
    },
    updateQuestionText(e) {
      this.setQuestionText(e.target.value)
    },
    updatePoints(e) {
      this.setPoints(e.target.value)
    },
    getRoute(name) {
      return `${axios.defaults.baseURL}${name}/media`
    },
    submitForm() {
      this.storeData()
        .then(() => {
          this.$router.push({ name: 'questions.index' })
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
