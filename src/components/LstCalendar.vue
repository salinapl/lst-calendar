<!--- !!! OLD !!!
<template>
    <k-panel-inside>
        <k-header>LST Calendar</k-header>
        <h2>Kirby Collections</h2>
        <h3>Slides Collection</h3>
        <ul>
            <li v-for="item in slidesCollection" :key="item.id">
                <p>Item Title:{{ item.title }}</p>
                <img :src="item.image" style="max-width: 300px;"></img>
                <p>Start:{{ item.start }}</p>
                <p>Expire:{{ item.expire }}</p>
            </li>
        </ul>
        <h3>Events Collection</h3>
        <ul>
            <li v-for="item in eventsCollection" :key="item.id">
                <p>Item Title:{{ item.title }}</p>
                <p>Start:{{ item.start }}</p>
                <p>Expire:{{ item.expire }}</p>
            </li>
        </ul>
    </k-panel-inside>
</template>

<script>
    export default {
        props: {
            // computed by the PHP part of the field in the plugin's index.php
            slidesCollection: Array,
            eventsCollection: Array
        },
        setup(props) {
            console.log(`The slides collection includes:\n${props.slidesCollection}\n`);
            console.log(`The events collection includes:\n${props.eventsCollection}\n`);
        }
    }    
</script>
-->

<script setup>
    const prop = defineProps({
        slidesCollection: Array,
        eventsCollection: Array
    });
</script>

<template>
    <k-panel-inside>
        <k-header>LST Calendar</k-header>
    </k-panel-inside>   
</template>