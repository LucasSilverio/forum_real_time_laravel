<template>
    <div class="card">
        <div class="card-content">
            <span class="card-title">{{ title }}</span>

            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ threads }}</th>
                        <th>{{ replies }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="thread in threds_response.data">
                        <td>{{ thread.id }}</td>
                        <td>{{ thread.title }}</td>
                        <td>{{ thread.replies_count || 0 }}</td>
                        <td>
                            <a :href="'/threads/'+ thread.id">{{ open }}</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="card-content">
            <span class="card-title">{{newThread}}</span>

            <form @submit.prevent="save()">
                <div class="input-field">
                    <input type="text" :placeholder="threadTitle" v-model="threads_to_save.title"/>
                </div>
                <div class="input-field">
                    <textarea class="materialize-textarea" :placeholder="threadBody" v-model="threads_to_save.body"></textarea>
                </div>
                <button type="submit" class="btn red accent-2">{{send}}</button>
            </form>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
    export default {
        props:[
            'title',
            'threads',
            'replies',
            'open',
            'newThread',
            'threadTitle',
            'threadBody',
            'send'
        ],
        data() {
            return{
                threds_response: [],
                threads_to_save: {
                    title:'',
                    body:''
                },
            }            
        },
        mounted(){
            this.getThreads(); 
            
            Echo.channel('new.thread')
                .listen('NewThread', (e) => {
                    if (e.thread) {
                        this.threds_response.data.splice(0, 0, e.thread)
                    }
                });
        },
        methods:{
            async getThreads(){
               await axios.get('/threads')
                    .then(response=>{
                        this.threds_response = response.data
                    })
                    .catch(error=>{
                        console.log(error)
                    })
            },
            async save(){
                await axios.post('/threads', this.threads_to_save)
                    .then(response=>{
                        this.getThreads()
                    })
                    .catch(error=>{
                        console.log(error)
                    })
            }
        }
    }
</script>
