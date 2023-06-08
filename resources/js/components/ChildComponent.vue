<template>
<h2> hello</h2>
<a href="javascript:void(0)" @click="testing_call(12)"> Calll</a> 
</template>

<script>

export default{
     mounted(){
        
     },
     props:{
        callMethod:'',
        callChild: ''
     },
    methods:{
        testing_call(id){
            alert('testing_call..');
            this.callMethod(id);
        },
        childCall(id){
            alert('CALL re'+id);
        }
    }
}
</script>