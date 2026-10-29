<template>
    <k-panel-inside>
        <k-header>LST Calendar</k-header>
        <h2>Kirby Collections</h2>
        <h3>Slides Collection</h3>
        <ul>
            <li v-for="item in slidesCollection" :key="item.id">
                <p>{{ item.title }}</p>
                <p>{{ item.start }}</p>
                <p>{{ item.expire }}</p>
            </li>
        </ul>
        <h3>Events Collection</h3>
        <ul>
            <li v-for="item in eventsCollection" :key="item.id">
                <p>{{ item.title }}</p>
                <p>{{ item.start }}</p>
                <p>{{ item.expire }}</p>
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
        }
    }    
</script>
