<template>
  <!-- 返回顶部 -->
  <transition name="move">
    <div v-show="showBackTop" :style="backTopStyle" @click="backTop">
      <i :class="icon" :style="{lineHeight: height + 'px'}" ></i>
      <span :style="{height: ~~result + '%'}">{{result}}%</span>
    </div>
  </transition>
</template>

<style scoped lang="">
  div {
    position: fixed;
    z-index: 9000;
    cursor: pointer;
    border-radius: 50%;
    background: #B3B3B3;
    text-align: center;
    color: #fff;
    font-size: 12px;
    overflow: hidden;
  }
  div span {
      position: absolute;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      display: block;
      background: #00b5ad;
  }
  div i {
      transform: rotate(180deg);
  }
  .move-enter-active, .move-leave-active{
    transition: all 0.4s linear;
  }
  .move-enter, .move-leave-active{
    opacity: 0;
    transform: translateX(40px) rotate(360deg);
  }
  .move-enter, .move-leave-active .in{
    opacity: 0;
    transform: translateX(-40px) rotate(-180deg);
  }
</style>

<script>
    export default {
        name: 'back-top',
        props: {
            right: {
                type: Number,
                default: 40
            },
            bottom: {
                type: Number,
                default: 40
            },
            top: {
                type: Number,
                default: 200
            },
            width: {
                type: Number,
                default: 40
            },
            height: {
                type: Number,
                default: 40
            },
            icon: {
                type: String,
                default: `el-icon-caret-top`
            },
            callback: {
                type: Function,
                default: () => {}
            }
        },
        data () {
            return {
                showBackTop: false,
                result: ``
            }
        },
        methods: {
            getScrollTop () {
                let bodyScrollTop = 0
                let documentScrollTop = 0
                if (document.body) bodyScrollTop = document.body.scrollTop
                if (document.documentElement) documentScrollTop = document.documentElement.scrollTop
                return bodyScrollTop - documentScrollTop > 0 ? bodyScrollTop : documentScrollTop
            },
            backTop () {
                let i = 60
                while (i >= 0) {
                    i--
                    setTimeout((i => {
                        return () => {
                            document.documentElement.scrollTop = document.documentElement.scrollTop * i / 60
                            document.body.scrollTop = document.body.scrollTop * i / 60
                        }
                    })(i), 1000 * (1 - i / 60))
                }
            },
            // 滚动
            toggleToTop () {
                // 页面总高
                var totalH = document.body.scrollHeight || document.documentElement.scrollHeight
                // 可视高
                var clientH = window.innerHeight || document.documentElement.clientHeight
                // 计算有效高
                var validH = totalH - clientH
                // 计算出来的百分比
                this.result = (this.getScrollTop() / validH * 100).toFixed(1)
                if (~~this.result >= 100) {
                    this.result = 100
                }
                this.showBackTop = this.getScrollTop() > this.top
            }
        },
        mounted () {
            window.addEventListener(`scroll`, this.toggleToTop, false)
        },
        destroy () {
            window.removeEventListener(`scroll`, this.toggleToTop, false)
        },
        computed: {
            backTopStyle () {
                return {
                    right: `${this.right}px`,
                    bottom: `${this.bottom}px`,
                    height: `${this.height}px`,
                    width: `${this.width}px`,
                    lineHeight: `${this.height}px`,
                }
            }
        },
        created () {
        }
    }
</script>