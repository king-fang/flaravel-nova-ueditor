<template>
    <default-field :field="field" :errors="errors">
        <template slot="field">
            <UE :content="field.value"
                :id="field.name"
                :class="errorClasses"
                :config=config
                :url="field.serveUrl"
                @ueValue="handleChange"
                v-model="value"  ref="ue"></UE>

            <p v-if="hasError" class="my-2 text-danger">
                {{ firstError }}
            </p>
        </template>
    </default-field>
</template>

<script>
import UE from './UE'
import { FormField, HandlesValidationErrors } from 'laravel-nova'

export default {
    data () {
        return {
            config: {
                initialFrameWidth: this.field.width,
                initialFrameHeight: this.field.height,
                autoHeightEnabled:false,
            },
            serveUrl: ''
        }
    },
    mixins: [FormField, HandlesValidationErrors],

    props: ['resourceName', 'resourceId', 'field'],

    methods: {
        /*
         * Set the initial, internal value for the field.
         */
        setInitialValue() {
            this.value = this.field.value || ''
        },

        /**
         * Fill the given FormData object with the field's internal value.
         */
        fill(formData) {
            formData.append(this.field.attribute, this.value || '')
        },

        /**
         * Update the field's internal value.
         */
        handleChange(value) {
            console.log(value)
            this.value = value
        },
    },
    components :{
        UE
    },
}
</script>
