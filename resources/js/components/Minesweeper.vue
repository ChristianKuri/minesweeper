<template>
    <div>
        <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-primary" @click="createMinesweeper">Create New Minesweeper</button>
            <button type="button" class="btn btn-primary" @click="loadOlds">Load Old Minesweepers</button>
        </div>
        <div class="d-flex mt-2">
            <div class="form-group">
                <label for="size">Size</label>
                <input type="number" name="size" id="size" class="form-control" placeholder="size" v-model="presets.size" min="1" max="24">
            </div>
            <div class="form-group">
                <label for="dificulty">Dificulty</label>
                <input type="number" name="dificulty" id="dificulty" class="form-control" placeholder="dificulty" v-model="presets.dificulty" min="1" max="100">
            </div>
        </div>
        <hr>
        <grid ref="grid" @lost="lost"></grid>
        <ul>
            <li v-for="minesweeper in oldMinesweppers" @click="load(minesweeper.id)" class="clickable">{{ minesweeper.created_at }}</li>
        </ul>  
    </div>
</template>

<script>
import Grid from './Grid'
import Swal from 'sweetalert2'

export default {
    components: {
        Grid,
        Swal
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
                mines: [],
                id: Number,
                updated: false
            },
            oldMinesweppers: Array,
            presets: {
                size: Number,
                dificulty: Number
            }
        }
    },

    methods: {
        createMinesweeper () {
            axios.post(this.minesweeperRoute, this.presets)
                .then((response) => {
                    this.sharedData.mines = response.data.mines
                    this.sharedData.id = response.data.id
                })
        },

        lost () {
            this.save()

            Swal.fire({
                title: 'Sorry!',
                text: 'You lost',
                type: 'error'
            })
        },

        save () {
            this.sharedData.updated = false
            axios.patch(`${this.minesweeperRoute}/${this.sharedData.id}`, {
                mines: this.sharedData.mines,
            })
        },

        loadOlds () {
            this.reset()
            axios.get(this.minesweeperRoute)
                .then((response) => {
                    this.oldMinesweppers = response.data.data
                })
        },

        reset () {
            this.sharedData.mines = []
            this.sharedData.id = Number
            this.oldMinesweppers = Array
        },

        load (id) {
            this.reset()
            axios.get(`${this.minesweeperRoute}/${id}`)
                .then((response) => {
                    this.sharedData.mines = response.data.mines
                    this.sharedData.id = response.data.id
                })

        }
    },

    mounted() {
        setInterval(() => {
            if (this.sharedData.id > 0 && this.sharedData.updated) {
                this.save();
            }
        }, 1000);
    }
}
</script>

<style>
.clickable {
    cursor: pointer;
}
</style>