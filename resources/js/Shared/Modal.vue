<template>
  <transition name="modal">
    <vue-draggable-resizable class-name="resizable" :enable-native-drag="false" :w="1" :h="1" :x="x" :y="y" :resizable="false" :parent="true" :on-drag-start="onDragStart" :on-drag="onDrag">
      <div class="modal-mask">
        <div class="modal-wrapper">
          <div class="modal-container">
            <div class="modal-header">
              <slot name="header">
                default header
              </slot>
            </div>

            <div class="modal-body">
              <slot name="body">
                default body
              </slot>
            </div>

            <div class="modal-footer">
              <slot name="footer">
                default footer
                <button class="modal-default-button" @click="$emit('close')">
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
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: table;
  transition: opacity 0.3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.modal-container {
  width: 300px;
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
