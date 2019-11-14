<template>
    <div>
        <script :id=id type="text/plain"></script>
    </div>
</template>

<script>
export default {
    name: "UE",
    props: {
        config: {
            type: Object
        },
        id: {
            type: String
        },
        content: {
            type: String
        },
        url: {
            type: String
        }
    },
    mounted () {
        this._initEditor()
    },
    methods: {
        _initEditor () { // 初始化
            var that = this
            window.UEDITOR_CONFIG.serverUrl = this.url
            this.editor = UE.getEditor(this.id,this.config)
            this.editor.ready(function () {
                that.editor.setContent(that.content || '')
                that.editor.addListener("contentchange", function () {
                    that.$emit('ueValue', that.getUEContent())
                })
            })

        },
        getUEContent () { // 获取含标签内容方法
            return this.editor.getContent()
        }
    },
    destroyed () {
        this.editor.destroy()
    }
}
</script>

<style scoped>

</style>
