<template>
  <div>
    <!-- <div id="generatorBg" class="generatorBg bgLoft" style="height: 788.938px; width: 1170px;" /> -->
    <div>
      <h1 class="mb-8 font-bold text-3xl title">Constructor</h1>
      <div style="text-align: center;">Use our constructor to create a neon sign and order it now!</div>
    </div>
    <div class="flex flex-wrap ">
      <div class="lg:w-1/2">
        <div class="pt-8 -mr-0 -mb-8 flex flex-wrap ">
          <div id="generatorTextContainer" class="generatorTextContainer panelAcrylic" style="width: 755px; margin-top: -20px;">
            <h1 id="generatorResultText" class="generatorResultText fontbubble colorBlue glowOn" style="font-size: 48px; height: 40px;">
              <span id="generatorResultTextSpan" :class="txtStylesArr" :style="styleObj">{{ curText }}</span>
            </h1>
          </div>
        </div>
      </div>

      <div class="lg:w-1/2">
        <div class="pt-8 -mr-0 -mb-8 flex flex-wrap ">
          <div class="lg:w-1/12">
            <ul id="generatorMenu" class="generatorMenu">
              <li>
                <a :class="[curTab == 'editText' ? 'menuActive' : '']" @click="changeTab('editText')">
                  <img src="storage/img/generator-1.png" />
                </a>
              </li>
              <li>
                <a :class="[curTab == 'editFont' ? 'menuActive' : '']" @click="changeTab('editFont')">
                  <img src="storage/img/generator-2.png" />
                </a>
              </li>
              <li>
                <a :class="[curTab == 'editSize' ? 'menuActive' : '']" @click="changeTab('editSize')">
                  <img src="storage/img/generator-3.png" />
                </a>
              </li>
              <li>
                <a :class="[curTab == 'editColor' ? 'menuActive' : '']" @click="changeTab('editColor')">
                  <img src="storage/img/generator-4.png" />
                </a>
              </li>
              <li>
                <a :class="[curTab == 'editCable' ? 'menuActive' : '']" @click="changeTab('editCable')">
                  <img src="storage/img/generator-5.png" />
                </a>
              </li>
              <li>
                <a :class="[curTab == 'editPanel' ? 'menuActive' : '']" @click="changeTab('editPanel')">
                  <img src="storage/img/generator-6.png" />
                </a>
              </li>
              <li>
                <a :class="[curTab == 'editlength' ? 'menuActive' : '']" @click="changeTab('editlength')">
                  <img src="storage/img/generator-7.png" />
                </a>
              </li>
              <li>
                <a :class="[curTab == 'editForm' ? 'menuActive' : '']" @click="changeTab('editForm')">
                  <img src="storage/img/generator-8.png" />
                </a>
              </li>
            </ul>
          </div>
          <div class="lg:w-5/12">
            <div v-if="curTab == 'editText'" id="generatorEditText" class="generatorMenuTab menuTabActive">
              <div class="menuTabTitle">
                <h2>Add text</h2>
              </div>
              <div class="menuTabBody">
                <p>Add your own text.</p>
                <textarea name="generatorTextInput" placeholder="Text" autocomplete="off" maxlength="20" spellcheck="false" @input="changeTxt($event.target.value)" />
              </div>
            </div>

            <div v-if="curTab == 'editFont'" id="generatorEditFont" class="generatorMenuTab menuTabActive">
              <div class="menuTabTitle">
                <h2>Choose a font</h2>
              </div>
              <div class="menuTabBody">
                <div class="colorPicker">
                  <div class="pickerRow twoButtons">
                    <a v-for="font in fonts" :key="font" :font="font" :class="[curFont == font ? 'pickerActive' : '', 'fontbubble', 'pickerButton', 'fontPickerButton']" @click="changeFont(font)"> {{ font }} </a>
                  </div>
                </div>
              </div>
            </div>

            <div v-if="curTab == 'editSize'" class="sizePicker">
              <div class="pickerRow">
                <a :class="[curSize == 'small' ? 'pickerActive' : '', 'pickerButton', 'sizePickerButton']" @click="changeSize('small')">Small</a>
                <a :class="[curSize == 'medium' ? 'pickerActive' : '', 'pickerButton', 'sizePickerButton']" @click="changeSize('medium')">Medium</a>
                <a :class="[curSize == 'large' ? 'pickerActive' : '', 'pickerButton', 'sizePickerButton']" @click="changeSize('large')">Large</a>
              </div>
            </div>

            <div v-if="curTab == 'editColor'" id="generatorEditColor" class="generatorMenuTab menuTabActive">
              <div class="menuTabTitle">
                <h2>Choose a color</h2>
              </div>
              <div class="menuTabBody">
                <div class="colorPicker">
                  <div class="pickerRow colorPickerRow">
                    <a :class="[curColor == 'Blue' ? 'pickerActive' : '', 'pickerButton', 'colorPickerButton', 'bgBlue']" @click="changeColor('Blue')" />
                    <a :class="[curColor == 'Yellow' ? 'pickerActive' : '', 'pickerButton', 'colorPickerButton', 'bgYellow']" @click="changeColor('Yellow')" />
                    <a :class="[curColor == 'White' ? 'pickerActive' : '', 'pickerButton', 'colorPickerButton', 'bgWhite']" @click="changeColor('White')" />
                  </div>
                  <div class="pickerRow colorPickerRow">
                    <a :class="[curColor == 'Green' ? 'pickerActive' : '', 'pickerButton', 'colorPickerButton', 'bgGreen']" @click="changeColor('Green')" />
                    <a :class="[curColor == 'Pink' ? 'pickerActive' : '', 'pickerButton', 'colorPickerButton', 'bgPink']" @click="changeColor('Pink')" />
                    <a :class="[curColor == 'Red' ? 'pickerActive' : '', 'pickerButton', 'colorPickerButton', 'bgRed']" @click="changeColor('Red')" />
                  </div>
                  <div class="pickerRow colorPickerRow">
                    <a :class="[curColor == 'WiteL' ? 'pickerActive' : '', 'pickerButton', 'colorPickerButton', 'bgWiteL']" @click="changeColor('WiteL')" />
                    <a :class="[curColor == 'WiteB' ? 'pickerActive' : '', 'pickerButton', 'colorPickerButton', 'bgWiteB']" @click="changeColor('WiteB')" />
                    <a :class="[curColor == 'Orange' ? 'pickerActive' : '', 'pickerButton', 'colorPickerButton', 'bgOrange']" @click="changeColor('Orange')" />
                  </div>
                  <div class="pickerRow colorPickerRow">
                    <a :class="[curColor == 'Sky' ? 'pickerActive' : '', 'pickerButton', 'colorPickerButton', 'bgSkyB']" @click="changeColor('Sky')" />
                    <a :class="[curColor == 'Purple' ? 'pickerActive' : '', 'pickerButton', 'colorPickerButton', 'bgPurple']" @click="changeColor('Purple')" />
                  </div>
                </div>
              </div>
            </div>

            <div v-if="curTab == 'editCable'" id="generatorEditCable" class="generatorMenuTab menuTabActive">
              <div class="menuTabTitle">
                <h2 class="smallHeader">Flicker Control</h2>
              </div>
              <div class="menuTabBody">
                <div class="colorPicker">
                  <div class="pickerRow">
                    <a :class="[curControl == 'Dimmer' ? 'pickerActive' : '', 'flickerPickerButton', 'pickerButton']" @click="changeControl('Dimmer')">Dimmer</a>
                    <a :class="[curControl == 'Remote control' ? 'pickerActive' : '', 'flickerPickerButton', 'pickerButton']" @click="changeControl('Remote control')">Remote control</a>
                    <a :class="[curControl == 'Nothing' ? 'pickerActive' : '', 'flickerPickerButton', 'pickerButton']" @click="changeControl('Nothing')">Nothing</a>
                  </div>
                </div>
              </div>
            </div>

            <div v-if="curTab == 'editPanel'" id="generatorEditPanel" class="generatorMenuTab menuTabActive">
              <div class="menuTabTitle">
                <h2>Backing board</h2>
              </div>
              <div class="menuTabBody">
                <div class="colorPicker">
                  <div class="pickerRow twoButtons">
                    <a :class="[panelColor == 'Clear Acrylic' ? 'pickerActive' : '', 'pickerButton', 'panelPickerButton']" @click="changePanelColor('Clear Acrylic')">Clear Acrylic</a>
                    <a :class="[panelColor == 'Alluminium' ? 'pickerActive' : '', 'pickerButton', 'panelPickerButton']" @click="changePanelColor('Alluminium')">Milk Acrylic</a>
                    <a :class="[panelColor == 'Wooden' ? 'pickerActive' : '', 'pickerButton', 'panelPickerButton']" @click="changePanelColor('Wooden')">Wood plastic</a>
                  </div>
                  <p class="pickerSecondary">The type of backing board</p>
                  <div class="pickerRow twoButtons">
                    <a :class="[panelShape == 'Square' ? 'pickerActive' : '', 'panelTypePickerButton', 'pickerButton']" @click="changePanelShape('Square')">Cut to rectangle</a>
                    <a :class="[panelShape == 'Figure' ? 'pickerActive' : '', 'panelTypePickerButton', 'pickerButton']" @click="changePanelShape('Figure')">Cut to shape</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout2'
export default {
  metaInfo: { title: 'Categories' },
  components: {},
  layout: Layout,

  props: {
    fonts: Array,
    categories: Object,
  },

  data() {
    return {
      mediumWidth: '90',
      curTab: 'editText',
      curText: 'Text',
      curFont: 'Arial',
      curSize: 'medium',
      curSizePx: '90',
      curColor: 'Black',
      curControl: 'Nothing',
      panelColor: 'Clear Acrylic',
      panelShape: 'Square',
      styleObj: {
        fontSize: '90px',
      },
      txtStylesArr: [],
    }
  },

  mounted: function() {},
  methods: {
    changeFont: function(v) {
      this.curFont = v
      this.styleObj.fontFamily = v
    },
    changeTab: function(v) {
      this.curTab = v
    },
    changeTxt: function(v) {
      this.curText = v
    },
    changeSize: function(v) {
      this.curSize = v
      this.curSizePx = this.mediumWidth

      if (v == 'small') {
        this.curSizePx = this.mediumWidth * 0.75
      } else if (v == 'large') {
        this.curSizePx = this.mediumWidth * 1.25
      }
      this.styleObj.fontSize = this.curSizePx + 'px'
    },
    changeColor: function(v) {
      let newClassName = 'color' + v
      let oldClassName = 'color' + this.curColor

      let index = this.txtStylesArr.indexOf(oldClassName)
      if (index !== -1) {
        this.txtStylesArr.splice(index, 1)
      }
      this.txtStylesArr.push(newClassName)

      this.curColor = v
      console.log(this.txtStylesArr)
    },
    changeControl: function(v) {
      this.curControl = v
    },
    changePanelColor: function(v) {
      this.panelColor = v
    },
    changePanelShape: function(v) {
      this.panelShape = v
    },
  },
}
</script>
<style scoped>
.title {
  flex: 1 100%;
  text-align: center;
  font-size: 40px;
  line-height: 45px;
}

#generatorMenu li {
  cursor: pointer;
  margin-bottom: 7px;
}
.pickerButton {
  margin-bottom: 15px;
  display: inline-flex;
  width: 100%;
  height: 50px;
  line-height: 47px;
  text-align: center;
  border: 2px solid #aaa;
  border-top-color: rgb(170, 170, 170);
  border-right-color: rgb(170, 170, 170);
  border-bottom-color: rgb(170, 170, 170);
  border-left-color: rgb(170, 170, 170);
  box-sizing: border-box;
  cursor: pointer;
  justify-content: center;
  transition: border-color 0.5s ease;
  -webkit-transition: border-color 0.5s ease;
  color: #000 !important;
}
.pickerRow,
.colorPicker {
  flex: 1 100%;
  display: flex;
  max-height: 200px;
  overflow: auto;
  flex-wrap: wrap;
  justify-content: space-between;
  margin-bottom: 0;
}

.menuTabTitle {
  height: 50px;
  line-height: 50px;
  border-bottom: 1px solid #ccc;
}

.menuTabTitle > h2 {
  color: #ff00ff;
  font-size: 20px;
  margin: 0;
  padding: 0;
  font-weight: 400;
  font-family: Comfortaa-Regular, sans-serif;
}
.menuTabBody {
  margin-top: 25px;
}
.menuActive {
  filter: drop-shadow(0px 0px 5px rgba(255, 0, 255, 1));
}
.menuTabBody textarea {
  resize: vertical;
  width: 100%;
  height: 80px;
  border: 2px solid #666;
  box-sizing: border-box;
  display: block;
  font-size: 16px;
  padding: 8px;
  margin-top: 15px;
}
.bgLoft {
  background-image: url(http://local-notes-vue.com/storage/img/loftdarkflip.jpg);
  background-size: cover;
  height: 788.938px;
  width: 1170px;
  z-index: -1;
}

.generatorBg {
  position: absolute;
  left: 0;
  top: 0;
  width: 100%;
  height: 100px;
  background-size: contain;
}

.generatorTextContainer {
  position: absolute;
  left: 0;
  top: 40%;
  margin-left: -15px;
  width: 100%;
  text-align: center;
}
.pickerButton.pickerActive {
  border-color: #000;
}
#generatorEditColor .pickerRow .pickerButton,
#generatorEditColor .colorPicker .pickerButton {
  flex: 0 33%;
}
.bgBlue {
  background-color: rgb(41, 109, 197);
}
.bgYellow {
  background-color: rgb(255, 245, 0);
}
.bgWhite {
  background-color: #fff;
}
.bgGreen {
  background-color: rgb(0, 255, 71);
}
.bgPink {
  background-color: #ff69b4;
}
.bgRed {
  background-color: rgb(255, 0, 0);
}
.bgWiteL {
  background-color: #fffacd;
}
.bgWiteB {
  background-color: #f0ffff;
}
.bgOrange {
  background-color: #ff8c00;
}
.bgSkyB {
  background-color: #00bfff;
}
.bgPurple {
  background-color: #c71585;
}
.colorGreen {
  text-shadow: 0 3px 20px rgba(0, 255, 71, 0.4), 0 3px 20px rgba(0, 255, 71, 0.4), 0 3px 20px rgba(0, 255, 71, 0.4), 0 3px 20px rgba(0, 255, 71, 0.4), 0 3px 20px rgba(0, 255, 71, 0.4), 0 3px 20px rgba(0, 255, 71, 0.4), 0 3px 20px rgba(0, 255, 71, 0.4), 0 3px 20px rgba(0, 255, 71, 0.4) !important;
  color: #00ff47 !important;
}
.colorPink {
  text-shadow: 0 3px 20px rgba(255, 105, 180, 0.4), 0 3px 20px rgba(255, 105, 180, 0.4), 0 3px 20px rgba(255, 105, 180, 0.4), 0 3px 20px rgba(255, 105, 180, 0.4), 0 3px 20px rgba(255, 105, 180, 0.4), 0 3px 20px rgba(255, 105, 180, 0.4), 0 3px 20px rgba(255, 105, 180, 0.4), 0 3px 20px rgba(255, 105, 180, 0.4) !important;
  color: #ff69b4 !important;
}
.colorRed {
  text-shadow: 0 3px 20px rgba(255, 0, 0, 0.4), 0 3px 20px rgba(255, 0, 0, 0.4), 0 3px 20px rgba(255, 0, 0, 0.4), 0 3px 20px rgba(255, 0, 0, 0.4), 0 3px 20px rgba(255, 0, 0, 0.4), 0 3px 20px rgba(255, 0, 0, 0.4), 0 3px 20px rgba(255, 0, 0, 0.4), 0 3px 20px rgba(255, 0, 0, 0.4) !important;
  color: red !important;
}
.colorWiteL {
  color: #fffacd;
  text-shadow: 0 3px 20px rgba(255, 250, 205, 0.4), 0 3px 20px rgba(255, 250, 205, 0.4), 0 3px 20px rgba(255, 250, 205, 0.4), 0 3px 20px rgba(255, 250, 205, 0.4), 0 3px 20px rgba(255, 250, 205, 0.4), 0 3px 20px rgba(255, 250, 205, 0.4), 0 3px 20px rgba(255, 250, 205, 0.4), 0 3px 20px rgba(255, 250, 205, 0.4) !important;
}
.colorWiteB {
  color: #f0ffff;
  text-shadow: 0 3px 20px rgba(240, 255, 255, 0.4), 0 3px 20px rgba(240, 255, 255, 0.4), 0 3px 20px rgba(240, 255, 255, 0.4), 0 3px 20px rgba(240, 255, 255, 0.4), 0 3px 20px rgba(240, 255, 255, 0.4), 0 3px 20px rgba(240, 255, 255, 0.4), 0 3px 20px rgba(240, 255, 255, 0.4), 0 3px 20px rgba(240, 255, 255, 0.4) !important;
}
.colorOrange {
  color: #ff8c00;
  text-shadow: 0 3px 20px rgba(255, 140, 0, 0.4), 0 3px 20px rgba(255, 140, 0, 0.4), 0 3px 20px rgba(255, 140, 0, 0.4), 0 3px 20px rgba(255, 140, 0, 0.4), 0 3px 20px rgba(255, 140, 0, 0.4), 0 3px 20px rgba(255, 140, 0, 0.4), 0 3px 20px rgba(255, 140, 0, 0.4), 0 3px 20px rgba(255, 140, 0, 0.4) !important;
}
.colorSky {
  color: #00bfff;
  text-shadow: 0 3px 20px rgba(0, 191, 255, 0.4), 0 3px 20px rgba(0, 191, 255, 0.4), 0 3px 20px rgba(0, 191, 255, 0.4), 0 3px 20px rgba(0, 191, 255, 0.4), 0 3px 20px rgba(0, 191, 255, 0.4), 0 3px 20px rgba(0, 191, 255, 0.4), 0 3px 20px rgba(0, 191, 255, 0.4), 0 3px 20px rgba(0, 191, 255, 0.4) !important;
}
.colorBlue {
  text-shadow: 0 3px 20px rgba(89, 161, 255, 0.4), 0 3px 20px rgba(89, 161, 255, 0.4), 0 3px 20px rgba(89, 161, 255, 0.4), 0 3px 20px rgba(89, 161, 255, 0.4), 0 3px 20px rgba(89, 161, 255, 0.4), 0 3px 20px rgba(89, 161, 255, 0.4), 0 3px 20px rgba(89, 161, 255, 0.4), 0 3px 20px rgba(89, 161, 255, 0.4) !important;
  color: #59a1ff !important;
}
.colorYellow {
  text-shadow: 0 3px 20px rgba(255, 245, 0, 0.4), 0 3px 20px rgba(255, 245, 0, 0.4), 0 3px 20px rgba(255, 245, 0, 0.4), 0 3px 20px rgba(255, 245, 0, 0.4), 0 3px 20px rgba(255, 245, 0, 0.4), 0 3px 20px rgba(255, 245, 0, 0.4), 0 3px 20px rgba(255, 245, 0, 0.4), 0 3px 20px rgba(255, 245, 0, 0.4) !important;
  color: #fff500 !important;
}
.colorWhite {
  text-shadow: 0 3px 20px rgba(255, 255, 255, 0.4), 0 3px 20px rgba(255, 255, 255, 0.4), 0 3px 20px rgba(255, 255, 255, 0.4), 0 3px 20px rgba(255, 255, 255, 0.4) !important;
  color: #fff !important;
}
.colorPurple {
  color: #c71585;
  text-shadow: 0 3px 20px rgba(199, 21, 133, 0.4), 0 3px 20px rgba(199, 21, 133, 0.4), 0 3px 20px rgba(199, 21, 133, 0.4), 0 3px 20px rgba(199, 21, 133, 0.4), 0 3px 20px rgba(199, 21, 133, 0.4), 0 3px 20px rgba(199, 21, 133, 0.4), 0 3px 20px rgba(199, 21, 133, 0.4), 0 3px 20px rgba(199, 21, 133, 0.4) !important;
}
</style>
