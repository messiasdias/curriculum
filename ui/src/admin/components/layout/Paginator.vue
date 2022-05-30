<template>
<div class="row mt-4">
    <div class="col-sm-6">
        <div>
            <p class="mb-sm-0 mt-2">Página <span class="fw-bold">{{page}}</span> de <span
                    class="fw-bold">{{last_page}}</span></p>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="float-sm-end">
            <ul class="pagination pagination-rounded mb-sm-0">
                <li v-if="page >  last_page" class="page-item">
                    <a @click.prevent="paginate(1)" href="#" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                </li>
                <li v-if="page > 1" class="page-item">
                    <a @click.prevent="paginate(page - 1)" href="#" class="page-link">{{page - 1}}</a>
                </li>
                <li class="page-item active" >
                    <a @click.prevent="paginate(page)" href="#" class="page-link">{{page}}</a>
                </li>
                <li v-if="(page + 1) <= last_page" class="page-item">
                    <a @click.prevent="paginate(page + 1)" href="#" class="page-link">{{page + 1}}</a>
                </li>
                <li v-if="(page + 2) <= last_page" class="page-item">
                    <a @click.prevent="paginate(page + 2)" href="#" class="page-link">{{page + 2}}</a>
                </li>
                <li v-if="(page + 3) <= last_page" class="page-item">
                    <a @click.prevent="paginate(page + 3)" href="#" class="page-link">{{page + 3}}</a>
                </li>
                <li class="page-item">
                    <a @click.prevent="paginate(last_page)" href="#" class="page-link"><i class="mdi mdi-chevron-end"></i></a>
                </li>
            </ul>
        </div>
    </div>
</div>
</template>
<script>
export default {
    name: 'paginator',
    props: {
        page: {
            type: Number,
            default: 1
        },
        last_page: {
            type: Number,
            default: 1
        },
        dispatchEvent: String,
    },
    methods: {
        paginate(page){
            this.$store.dispatch(this.dispatchEvent, page)
            this.$emit("paginate", {
                page: page,
                event: this.dispatchEvent
            })
        }
    }
}
</script>