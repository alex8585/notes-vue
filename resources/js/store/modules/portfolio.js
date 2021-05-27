import Form from '@inertiajs/inertia-vue/src/form.js'
import throttle from 'lodash/throttle'
//import pickBy from 'lodash/pickBy'
import { Inertia } from '@inertiajs/inertia'
import { getUrlQuery } from '@/utils'

const state = {
  showDeleteDialog: false,
  showModalEdit: false,
  isUnselectable: false,
  showModalCreate: false,
  deleteDialogItem: null,
  imgUrl: false,
  filterForm: Form({
    search: null,
    trashed: null,
  }),
  form: Form({
    img: null,
    title: null,
    url: null,
    tags: [],
    description: null,
  }),
  editForm: Form({
    id: null,
    img: null,
    title: null,
    url: null,
    tags: [],
    description: null,
    _method: 'put',
  }),
}

const getters = {
  imgUrl() {
    return state.imgUrl
  },
  showDeleteDialog() {
    return state.showDeleteDialog
  },
  showModalEdit() {
    return state.showModalEdit
  },
  isUnselectable() {
    return state.isUnselectable
  },
  showModalCreate() {
    return state.showModalCreate
  },
  form() {
    return state.form
  },
  editForm() {
    return state.editForm
  },
  filterForm() {
    return state.filterForm
  },
  deleteDialogItem() {
    return state.deleteDialogItem
  },
}

const actions = {
  setUnselectable: ({ commit }, v) => commit('SET_UNSELECTABLE', v),
  setShowModalCreate: ({ commit }, v) => commit('SET_MODAL_CREATE', v),
  setShowModalEdit: ({ commit }, v) => commit('SET_MODAL_EDIT', v),
  editPortfolio: ({ commit }, item) => commit('EDIT_PORTFOLIO', item),
  setDeleteDialog: ({ commit }, v) => commit('SET_DELETE_DIALOG', v),
  setDeleteDialogItem: ({ commit }, item) => {
    commit('SET_DELETE_DIALOG_ITEM', item)
    commit('SET_DELETE_DIALOG', true)
  },

  store({ commit }) {
    //console.log(state.form)
    state.form.post(route('portfolios.store'), {
      replace: true,
      preserveState: true,
      forceFormData: true,
      onSuccess: () => {
        commit('RESET_FORM')
        commit('SET_MODAL_CREATE', false)
      },
    })
  },
  update({ commit }) {
    //console.log(state.editForm)
    state.editForm.post(route('portfolios.update', state.editForm.id), {
      replace: true,
      preserveState: true,
      forceFormData: true,
      onSuccess: () => {
        commit('RESET_FORM')
        commit('SET_MODAL_EDIT', false)
      },
    })
  },
  delete({ commit }, item) {
    Inertia.delete(route('portfolios.destroy', item.id), {
      //preserveScroll: true,
      replace: true,
      preserveState: true,
      onSuccess: () => {
        commit('SET_DELETE_DIALOG', false)
      },
    })
  },

  filterChange: throttle(function({ commit }, value) {
    if (value == 'reset') {
      commit('RESET_FILTER_FORM', false)
    }

    let query = {
      search: state.filterForm.search,
      trashed: state.filterForm.trashed,
    }
    state.filterForm.get(route(route().current(), query), {
      replace: true,
      preserveState: true,
      onSuccess: () => {},
    })
    // eslint-disable-next-line no-undef
    //Inertia.get(route(route().current()), query, { replace: true, preserveState: true })
  }, 500),
  sortHanle({ commit }, { sort, defaultDirection }) {
    let query = getUrlQuery()

    let direction = query.direction ? query.direction : defaultDirection

    direction = direction == 'asc' ? 'desc' : 'asc'

    query = { ...query, direction, sort }

    Inertia.get(route(route().current()), query, {
      //preserveScroll: true,
      replace: true,
      preserveState: true,
    })
  },
}

const mutations = {
  RESET_FILTER_FORM: state => state.filterForm.reset(),
  RESET_FORM: state => state.form.reset(),
  SET_UNSELECTABLE: (state, v) => (state.isUnselectable = v),
  SET_DELETE_DIALOG: (state, v) => (state.showDeleteDialog = v),
  SET_DELETE_DIALOG_ITEM: (state, item) => (state.deleteDialogItem = item),

  SET_MODAL_CREATE: (state, v) => {
    state.showModalCreate = v
    if (v == false) {
      state.isUnselectable = false
    }
  },
  SET_MODAL_EDIT: (state, v) => {
    state.showModalEdit = v
    if (v == false) {
      state.isUnselectable = false
    }
  },
  EDIT_PORTFOLIO: (state, item) => {
    state.editForm = { ...state.editForm, ...item }
    //console.log(state.editForm)
    state.imgUrl = item.imgUrl
    state.editForm.img = null
    if (!state.showModalEdit) state.showModalEdit = true
  },
}

export default {
  state,
  getters,
  actions,
  mutations,
}
