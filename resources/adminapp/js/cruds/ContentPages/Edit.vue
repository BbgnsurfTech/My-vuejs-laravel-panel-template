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
                <strong>{{ $t('cruds.contentPage.title_singular') }}</strong>
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
                      'has-items': entry.title,
                      'is-focused': activeField == 'title'
                    }"
                  >
                    <label class="bmd-label-floating required">{{
                      $t('cruds.contentPage.fields.title')
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
                  <div
                    class="form-group bmd-form-group"
                    :class="{
                      'has-items': entry.category.length !== 0,
                      'is-focused': activeField == 'category'
                    }"
                  >
                    <label class="bmd-label-floating">{{
                      $t('cruds.contentPage.fields.category')
                    }}</label>
                    <v-select
                      name="category"
                      label="name"
                      :key="'category-field'"
                      :value="entry.category"
                      :options="lists.category"
                      :closeOnSelect="false"
                      multiple
                      @input="updateCategory"
                      @search.focus="focusField('category')"
                      @search.blur="clearFocus"
                    />
                  </div>
                  <div
                    class="form-group bmd-form-group"
                    :class="{
                      'has-items': entry.tag.length !== 0,
                      'is-focused': activeField == 'tag'
                    }"
                  >
                    <label class="bmd-label-floating">{{
                      $t('cruds.contentPage.fields.tag')
                    }}</label>
                    <v-select
                      name="tag"
                      label="name"
                      :key="'tag-field'"
                      :value="entry.tag"
                      :options="lists.tag"
                      :closeOnSelect="false"
                      multiple
                      @input="updateTag"
                      @search.focus="focusField('tag')"
                      @search.blur="clearFocus"
                    />
                  </div>
                  <div class="form-group">
                    <label>{{
                      $t('cruds.contentPage.fields.page_text')
                    }}</label>
                    <ckeditor
                      :editor="editor"
                      :value="entry.page_text"
                      @input="updatePageText"
                    >
                    </ckeditor>
                  </div>
                  <div
                    class="form-group bmd-form-group"
                    :class="{
                      'has-items': entry.excerpt,
                      'is-focused': activeField == 'excerpt'
                    }"
                  >
                    <label class="bmd-label-floating">{{
                      $t('cruds.contentPage.fields.excerpt')
                    }}</label>
                    <textarea
                      class="form-control"
                      rows="5"
                      :value="entry.excerpt"
                      @input="updateExcerpt"
                      @focus="focusField('excerpt')"
                      @blur="clearFocus"
                    ></textarea>
                  </div>
                  <div class="form-group">
                    <label>{{
                      $t('cruds.contentPage.fields.featured_image')
                    }}</label>
                    <attachment
                      :route="getRoute('content-pages')"
                      :collection-name="'content_page_featured_image'"
                      :media="entry.featured_image"
                      :model-id="$route.params.id"
                      :max-file-size="2"
                      :component="'pictures'"
                      :accept="'image/*'"
                      @file-uploaded="insertFeaturedImageFile"
                      @file-removed="removeFeaturedImageFile"
                      :max-files="1"
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
import ClassicEditor from '@ckeditor/ckeditor5-build-classic'
import Attachment from '@components/Attachments/Attachment'

export default {
  components: {
    ClassicEditor,
    Attachment
  },
  data() {
    return {
      status: '',
      activeField: '',
      editor: ClassicEditor
    }
  },
  computed: {
    ...mapGetters('ContentPagesSingle', ['entry', 'loading', 'lists'])
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
    ...mapActions('ContentPagesSingle', [
      'fetchEditData',
      'updateData',
      'resetState',
      'setTitle',
      'setCategory',
      'setTag',
      'setPageText',
      'setExcerpt',
      'insertFeaturedImageFile',
      'removeFeaturedImageFile'
    ]),
    updateTitle(e) {
      this.setTitle(e.target.value)
    },
    updateCategory(value) {
      this.setCategory(value)
    },
    updateTag(value) {
      this.setTag(value)
    },
    updatePageText(value) {
      this.setPageText(value)
    },
    updateExcerpt(e) {
      this.setExcerpt(e.target.value)
    },
    getRoute(name) {
      return `${axios.defaults.baseURL}${name}/media`
    },
    submitForm() {
      this.updateData()
        .then(() => {
          this.$router.push({ name: 'content_pages.index' })
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
