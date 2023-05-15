<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Upload</div>

                <div class="card-body">
                    <input type="file" name="video" id="video" class="form-control" @change="fileInputChange" v-if="!uploading" />

                    <div id="video-form" v-if="uploading && !failed">
                            here
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import axios from 'axios'

    export default {
        data(){
            return{
                uid:'',
                uploading:false,
                uploadComplete:false,
                failed:false,
                title:'untitled',
                description:null,
                visibilty:'private',
            }
        },
        methods:{
            fileInputChange()
            {
                this.uploading =true
                this.failed=false
                let file=document.getElementById('video').files[0]
                this.store(file).then((res)=>{
                    console.log(res)
                })
            },
            store(file)
            {
                console.log(file)
              return axios.post('/video',{
                title:this.title,
                description:this.description,
                visibilty:this.visibilty,
                extension:file.name.split('.').pop()
              }).then((res)=>{
                this.uid=res.json().data.uid;
              })
                
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
