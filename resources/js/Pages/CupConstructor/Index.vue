<template>
  <div>
    <div>
      <h1 class="mb-8 font-bold text-3xl title">Cup Constructor</h1>
      <div style="text-align: center;">Use our constructor to create Cup and order it now!</div>
    </div>
    <div class="flex flex-wrap ">
      <div class="lg:w-8/12">
        <div id="scene" class=""></div>
      </div>

      <div class="lg:w-4/12">
        <div class=" m-10">
          <div class=""><img v-if="thumbnail" class="block w-8 h-8 rounded-full ml-4" :src="thumbnail" /></div>
          <form>
            <!-- <div class="  flex flex-wrap">
              <file-input v-model="form.photo" :error="form.errors.photo" class="pr-6 pb-8 w-full lg:w-1/2" type="file" accept="image/*" label="Photo" />
            </div>
            <div class=" py-4 bg-gray-50 border-t border-gray-100 flex items-center">
              <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update User</loading-button>
            </div> -->
            <file-input v-model="form.photo" :error="form.errors.photo" type="file" accept="image/*" label="Photo" @input="uploadFile" />
          </form>
          <form v-if="path">
            <clipper-basic :src="path" ref="clipper" @load="loadCb" />
            <button class="btn-indigo" type="submit" @click.prevent="cropImg">Crop</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { clipperBasic } from 'vuejs-clipper'
import LoadingButton from '@/Shared/LoadingButton'
import Layout from '@/Shared/Layout2'
import FileInput from '@/Shared/FileInput'
import * as THREE from 'three'
import { GLTFLoader } from 'three/examples/jsm/loaders/GLTFLoader'
import { OrbitControls } from 'three/examples/jsm/controls/OrbitControls'
import Dat from 'dat.gui'
import init from 'three-dat.gui'
import axios from 'axios'
export default {
  metaInfo: { title: 'Cup Constructor' },
  components: { FileInput, LoadingButton, clipperBasic },
  layout: Layout,

  props: {
    categories: Object,
  },

  data() {
    return {
      path: '',
      thumbnail: '',
      form: this.$inertia.form({
        photo: null,
      }),
      gltf: null,
      cup: null,
      camera: null,
      scene: null,
      renderer: null,
      params: {
        offsetX: 0,
        offsetY: 0,
        repeatX: 0,
        repeatY: 0,
        rotation: 0,
        centerX: 0,
        centerY: 0,
      },
    }
  },

  mounted: function() {
    init(Dat)
    this.treeInit()
    this.loadGltf()
    //const canvas = this.$refs.clipper.clip()
    window.addEventListener('resize', this.onWindowResize)
  },

  methods: {
    loadCb: function() {},

    loadGltf: function() {
      const loader = new GLTFLoader()
      let self = this
      loader.load(
        './storage/models/4.glb',
        function(gltf1) {
          gltf1.parser.getDependencies('mesh').then(mesh => {
            let mat0 = new THREE.MeshBasicMaterial({ color: 0xd8e0d0 })
            let mat1 = new THREE.MeshBasicMaterial({ color: 0xffffff })
            let mat2 = new THREE.MeshBasicMaterial({ color: 0xffffff })

            mesh[0].material = mat0
            mesh[1].material = mat1
            mesh[2].material = mat2
            self.cup = mesh[0]

            self.gltf = self.scene.add(gltf1.scene)
            self.gltf.rotation.x = 0.45
            self.treeAnimate()
            self.changTexture()
          })
        },
        undefined,
        function(error) {
          console.error(error)
        },
      )
    },

    treeInit: function() {
      this.camera = new THREE.PerspectiveCamera(70, window.innerWidth / window.innerHeight, 1, 1000)
      this.camera.position.z = 10

      this.scene = new THREE.Scene()

      this.renderer = new THREE.WebGLRenderer({ antialias: true })
      this.renderer.setClearColor(0x767775, 1)
      this.renderer.setPixelRatio(window.devicePixelRatio)

      let sceneNode = document.getElementById('scene')
      ///sceneNode.offsetWidth
      this.renderer.setSize(sceneNode.offsetWidth, sceneNode.offsetWidth / 2)
      sceneNode.appendChild(this.renderer.domElement)

      const controls = new OrbitControls(this.camera, this.renderer.domElement)
      controls.maxPolarAngle = Math.PI * 0.5

      //controls.minDistance = 1000
      //controls.maxDistance = 5000

      // const gui = new Dat.GUI()

      // gui
      //   .add(this.params, 'offsetX', -1, 1.0, 0.1)
      //   .name('offset.x')
      //   .onChange(this.changTexture)
      // gui
      //   .add(this.params, 'offsetY', -1, 1.0, 0.1)
      //   .name('offset.y')
      //   .onChange(this.changTexture)
      // gui
      //   .add(this.params, 'repeatX', -1, 2.0, 0.1)
      //   .name('repeat.x')
      //   .onChange(this.changTexture)
      // gui
      //   .add(this.params, 'repeatY', -1, 2.0, 0.1)
      //   .name('repeat.y')
      //   .onChange(this.changTexture)
      // gui
      //   .add(this.params, 'rotation', -10.0, 10.0, 0.1)
      //   .name('rotation')
      //   .onChange(this.changTexture)
      // gui
      //   .add(this.params, 'centerX', -1, 1.0, 0.1)
      //   .name('center.x')
      //   .onChange(this.changTexture)
      // gui
      //   .add(this.params, 'centerY', -1, 1.0, 0.1)
      //   .name('center.y')
      //   .onChange(this.changTexture)
    },

    treeAnimate: function() {
      requestAnimationFrame(this.treeAnimate)

      //this.gltf.rotation.y += 0.01

      this.renderer.render(this.scene, this.camera)
    },
    // sendForm() {
    //   this.form.post(this.route('cup-constructor.saveImage'), {
    //     onSuccess: r => {
    //       this.changTexture()
    //     },
    //   })
    // },
    onWindowResize() {
      this.camera.aspect = window.innerWidth / window.innerHeight
      this.camera.updateProjectionMatrix()
      this.renderer.setSize(window.innerWidth, window.innerHeight)
    },
    changTexture() {
      if (!this.path) return
      //console.log(this.path)
      //console.log(this.thumbnail)
      const texture = new THREE.TextureLoader().load(this.path)
      this.cup.side = THREE.DoubleSide
      texture.flipY = false
      texture.flipX = false
      texture.mapping = THREE.CubeUVRefractionMapping
      this.cup.material.map = texture
      this.cup.material.needsUpdate = true
    },
    cropImg() {
      console.log(this.$refs.clipper.zoomTL$)
      console.log(this.$refs.clipper.zoomWH$)
    },
    uploadFile(file) {
      if (!file) return

      let formData = new FormData()
      formData.append('photo', file)
      formData.append('_token', this.$page.props.csrf)
      axios
        .post(this.route('cup-constructor.saveImage'), formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        })
        .then(res => {
          this.path = res.data.path
          this.thumbnail = res.data.thumbnail
        })

      // this.form.post(this.route('cup-constructor.saveImage'), {
      //   onSuccess: r => {
      //     console.log(r)
      //     this.changTexture()
      //   },
      // })

      // this.$inertia.post(this.route('cup-constructor.saveImage'), data, {
      //   preserveState: true,
      //   replace: false,
      //   onSuccess: r => {
      //     console.log(r)
      //     this.changTexture()
      //   },
      // })
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
</style>
