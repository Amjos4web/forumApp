<template>
    <div>
        <small class="badge" :class="badgeClass">{{ user }}</small>
        <li class="list-group-item" :class="className"><slot></slot></li>
        
    </div>
</template>

<script>
    export default {
        props:[
            "color",
            "user"
        ],
        computed: {
            className(){
                return 'list-group-item-'+this.color;
            },
            badgeClass(){
                return 'badge-'+this.color;
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
