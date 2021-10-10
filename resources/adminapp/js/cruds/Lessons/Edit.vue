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
                <strong>{{ $t('cruds.lesson.title_singular') }}</strong>
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
                    <label class="bmd-label-floating required">{{
                      $t('cruds.lesson.fields.course')
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
                      'has-items': entry.title,
                      'is-focused': activeField == 'title'
                    }"
                  >
                    <label class="bmd-label-floating required">{{
                      $t('cruds.lesson.fields.title')
                    }}</label>
                    <input
                      class="form-control"
                      type="text"
                      :value="entry.title"
                      @input="updateTitle"
                      @focus="focusField('title')"
                      @blur="clearFocus"
                      required
                    />
                  </div>
                  <div class="form-group">
                    <label>{{ $t('cruds.lesson.fields.thumbnail') }}</label>
                    <attachment
                      :route="getRoute('lessons')"
                      :collection-name="'lesson_thumbnail'"
                      :media="entry.thumbnail"
                      :model-id="$route.params.id"
                      :max-file-size="2"
                      :component="'pictures'"
                      :accept="'image/*'"
                      @file-uploaded="insertThumbnailFile"
                      @file-removed="removeThumbnailFile"
                    />
                  </div>
                  <div
                    class="form-group bmd-form-group"
                    :class="{
                      'has-items': entry.short_text,
                      'is-focused': activeField == 'short_text'
                    }"
                  >
                    <label class="bmd-label-floating">{{
                      $t('cruds.lesson.fields.short_text')
                    }}</label>
                    <textarea
                      class="form-control"
                      rows="5"
                      :value="entry.short_text"
                      @input="updateShortText"
                      @focus="focusField('short_text')"
                      @blur="clearFocus"
                    ></textarea>
                  </div>
                  <div
                    class="form-group bmd-form-group"
                    :class="{
                      'has-items': entry.long_text,
                      'is-focused': activeField == 'long_text'
                    }"
                  >
                    <label class="bmd-label-floating">{{
                      $t('cruds.lesson.fields.long_text')
                    }}</label>
                    <textarea
                      class="form-control"
                      rows="5"
                      :value="entry.long_text"
                      @input="updateLongText"
                      @focus="focusField('long_text')"
                      @blur="clearFocus"
                    ></textarea>
                  </div>
                  <div class="form-group">
                    <label>{{ $t('cruds.lesson.fields.video') }}</label>
                    <attachment
                      :route="getRoute('lessons')"
                      :collection-name="'lesson_video'"
                      :media="entry.video"
                      :model-id="$route.params.id"
                      :max-file-size="2"
                      @file-uploaded="insertVideoFile"
                      @file-removed="removeVideoFile"
                      :max-files="1"
                    />
                  </div>
                  <div
                    class="form-group bmd-form-group"
                    :class="{
                      'has-items': entry.position,
                      'is-focused': activeField == 'position'
                    }"
                  >
                    <label class="bmd-label-floating">{{
                      $t('cruds.lesson.fields.position')
                    }}</label>
                    <input
                      class="form-control"
                      type="number"
                      step="1"
                      :value="entry.position"
                      @input="updatePosition"
                      @focus="focusField('position')"
                      @blur="clearFocus"
                    />
                  </div>
                  <div class="form-group form-check">
                    <label class="form-check-label"
                      ><input
                        class="form-check-input"
                        type="checkbox"
                        :value="entry.is_published"
                        :checked="entry.is_published"
                        @change="updateIsPublished"
                      /><span class="form-check-sign"
                        ><span class="check"></span></span
                      >{{ $t('cruds.lesson.fields.is_published') }}</label
                    >
                  </div>
                  <div class="form-group form-check">
                    <label class="form-check-label"
                      ><input
                        class="form-check-input"
                        type="checkbox"
                        :value="entry.is_free"
                        :checked="entry.is_free"
                        @change="updateIsFree"
                      /><span class="form-check-sign"
                        ><span class="check"></span></span
                      >{{ $t('cruds.lesson.fields.is_free') }}</label
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
    ...mapGetters('LessonsSingle', ['entry', 'loading', 'lists'])
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
    ...mapActions('LessonsSingle', [
      'fetchEditData',
      'updateData',
      'resetState',
      'setCourse',
      'setTitle',
      'insertThumbnailFile',
      'removeThumbnailFile',
      'setShortText',
      'setLongText',
      'insertVideoFile',
      'removeVideoFile',
      'setPosition',
      'setIsPublished',
      'setIsFree'
    ]),
    updateCourse(value) {
      this.setCourse(value)
    },
    updateTitle(e) {
      this.setTitle(e.target.value)
    },
    updateShortText(e) {
      this.setShortText(e.target.value)
    },
    updateLongText(e) {
      this.setLongText(e.target.value)
    },
    updatePosition(e) {
      this.setPosition(e.target.value)
    },
    updateIsPublished(e) {
      this.setIsPublished(e.target.checked)
    },
    updateIsFree(e) {
      this.setIsFree(e.target.checked)
    },
    getRoute(name) {
      return `${axios.defaults.baseURL}${name}/media`
    },
    submitForm() {
      this.updateData()
        .then(() => {
          this.$router.push({ name: 'lessons.index' })
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
