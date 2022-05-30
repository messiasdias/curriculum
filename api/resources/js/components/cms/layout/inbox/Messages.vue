<template>
<ul class="message-list">
    <template v-if="messages && messages.length > 0">
        <li
            v-for="message in messages"
            :key="message.id"
            :class="{'unread': message.status === 'new'}"
        >
            <div class="col-mail col-mail-1">
                <div class="checkbox-wrapper-mail">
                    <input @click="selectMessage(message.id)" :checked="selecteds.includes(message.id)" type="checkbox" :id="`message${message.id}`" >
                    <label class="form-label toggle" :for="`message${message.id}`"></label>
                </div>
                <router-link :to="`/inbox/${message.id}`" class="title"> {{message.name}}</router-link>
                <span @click.prevent="setStar(message.id, !message.star)" class="star-toggle fa-star" :class="{'far': !message.star, 'fa text-warning':  message.star}" ></span>
            </div>
            <div class="col-mail col-mail-2">
                <router-link :to="`/inbox/${message.id}`" class="subject">
                    <span 
                        class="badge me-2"
                        v-if="statusList" 
                        :class="{
                            'bg-info': message.status === 'readed',
                            'bg-success': message.status === 'resolved',
                            'bg-danger': message.status === 'new',
                        }"
                    >
                        {{statusList[message.status]}}
                    </span>

                    <span 
                        class="badge bg-warning me-2"
                        v-if="message.archived == true" 
                    >
                       Arquivado 
                    </span>

                    {{message.subject}} {{dateTimeToLocaleString(message.created_at) || '-'}}
                </router-link>
                <div class="date">{{dateTimeToLocaleString(message.created_at) || '-'}}</div>
            </div>
        </li>
    </template>
     <li v-else>
        <div class="col-mail col-mail-3">
            <a href="#" class="title">Nenhuma Mensagem encontrada</a>
        </div>
    </li>
</ul>
</template>
<script>
import {dateTimeToLocaleMoment} from './../../../../assets/helpers'
export default {
    name: "Messages",
    props: {
        messages: {
            type: Array,
            default: () => []
        },
        selectedMessages: {
            type: Array,
            default: () => []
        },
        statusList: {
            type: Object,
            default: () => null
        },
    },
    data(){
        return {
            selecteds: []
        }
    },
    watch: {
        selectedMessages(){
            this.selecteds = Object.assign([], this.selectedMessages)
        }
    },
    methods: {
        dateTimeToLocaleString:dateTimeToLocaleMoment,
        selectMessage(message){
            if (!this.selecteds.includes(message)) {
                this.selecteds.push(message)
                return this.$emit("selecteds", this.selecteds)
            }
            this.selecteds =  this.selecteds.filter(m => m != message)
            this.$emit("selecteds", this.selecteds)
        },
        setStar(id, star = false){
            this.$emit("selecteds", [id])
            this.$emit('star', star)
        }
    }
}
</script>