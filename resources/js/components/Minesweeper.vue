<template>
    <div>
        <button type="button" class="btn btn-primary" @click="createMinesweeper">Create New Minesweeper</button>
        <button type="button" class="btn btn-primary">Load Old Minesweepers</button>
        <hr>
        <grid ref="grid"></grid>
    </div>
</template>

<script>
import Grid from './Grid'

export default {
    components: {
        Grid
    },

    props: {
        minesweeperRoute: String
    },

    provide() {
        return {
            sharedData: this.sharedData
        }
    },

    data () {
        return {
            sharedData: {
                mines: []
            }
        }
    },

    methods: {
        createMinesweeper () {
            axios.post(this.minesweeperRoute)
                .then((response) => {
                    console.log(response.data)
                    this.sharedData.mines = response.data.mines
                })
                .catch(errors => console.log(errors))
        }
    },

    mounted () {
        
        //this.createMinesweeper()
    },
}
</script>

<style>
</style>