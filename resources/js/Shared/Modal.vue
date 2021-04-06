<template>
  <transition name="modal">
    <vue-draggable-resizable class-name="resizable" :enable-native-drag="false" :w="1" :h="1" :x="x" :y="y" :resizable="false" :parent="true" :on-drag-start="onDragStart" :on-drag="onDrag">
      <div class="modal-mask">
        <div class="modal-wrapper">
          <div class="modal-container">
            <div class="sm:flex sm:items-start">
              <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                <h3 id="modal-title" class="text-lg leading-6 font-medium text-gray-900">
                  <slot name="header">
                    Default header
                  </slot>
                </h3>
                <div class="">
                  <slot name="body">
                    Default body
                  </slot>
                </div>
              </div>
            </div>
            <div class="flex flex-row-reverse">
              <slot name="footer">
                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="$emit('close')">
                  Close
                </button>
              </slot>
            </div>
          </div>
        </div>
      </div>
    </vue-draggable-resizable>
  </transition>
</template>

<script>
import VueDraggableResizable from 'vue-draggable-resizable'
export default {
  components: { VueDraggableResizable },

  props: {
    x: { type: Number, default: 150 },
    y: { type: Number, default: 100 },
  },

  data() {
    return {}
  },

  mounted: function() {},
  methods: {
    onDragStart() {
      this.$emit('dragStart', 'start')
    },
    onDrag() {
      this.$emit('dragEnd', 'start')
    },
  },
}
</script>
<style scoped>
.modal-mask {
  z-index: 9998;

  width: 100%;
  height: 100%;

  display: table;
  transition: opacity 0.3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.modal-container {
  width: 600px;
  margin: 0px auto;
  padding: 20px 30px;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
  transition: all 0.3s ease;
  font-family: Helvetica, Arial, sans-serif;
}

.modal-header {
  margin-top: 0;
  color: #42b983;
}

.modal-body {
  margin: 20px 0;
}

.modal-default-button {
  float: right;
}

/*
 * The following styles are auto-applied to elements with
 * transition="modal" when their visibility is toggled
 * by Vue.js.
 *
 * You can easily play with the modal transition by editing
 * these styles.
 */
.modal-enter-active,
.modal-leave-active {
  transition: opacity 0.3s;
}
.modal-enter, .modal-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
</style>
