<template>
    <div id="app">
        <div class="col-lg-5">
            <multiselect
                v-model="selected"
                :options="options"
                :multiple="true"
                placeholder="Search and select multiple"
                label="name"
                track-by="name">
            </multiselect>
        </div>
        <br/><br/>
        <div class="col-lg-12">
            Data Selected: {{ selected }}
        </div>
    </div>
</template>
<script>
import Multiselect from 'vue-multiselect'

export default {
    name: 'app',
    data () {
        return {
            selected: null,
            options: [
                { name: 'Vue.js', language: 'JavaScript' },
                { name: 'Rails', language: 'Ruby' },
                { name: 'Sinatra', language: 'Ruby' },
                { name: 'Laravel', language: 'PHP', $isDisabled: true }
            ]
        }
    },
    components: {
        Multiselect
    }
}
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css">
</style>