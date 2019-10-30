<template>
    <div ref="container">
        <span v-for="(mineArray, row) in mines" class="mines-row">
            <span 
                v-for="(mine, col) in mineArray"
                @click.left="click(row, col)"
                @click.right.prevent="flag(row, col)"
                class="mines-element"
                :class="{ 'mine-open': mine.open && !mine.bomb, 'mine-exploded': mine.open && mine.bomb }" 
                :style="minesStyle"
                :row="row" :col="col">
                <i class="fa fa-flag" aria-hidden="true" v-if="mine.flagged"></i>
                {{ mine.show }}
            </span>
        </span>
    </div>
</template>

<script>
    export default {
        inject: ["sharedData"],

        computed: {
            mines() {
                return this.sharedData.mines.game
            },

            status() {
                return this.sharedData.mines.status
            },

            minesLength() {
                return this.mines.length
            },

            minesStyle() {
                return {
                    width: `${this.$refs.container.offsetWidth/this.minesLength}px`,
                    height: `${this.$refs.container.offsetWidth/this.minesLength}px`
                }
            }
        },

        methods: {

            click(row, col) {
                if (this.sharedData.mines.status == 'closed' || this.sharedData.mines.game[row][col]['flagged']) {
                    return
                }
                this.open(row, col)
                this.sharedData.updated = true
                this.sharedData.mines.game[row][col]['clicked'] = 1

                if (this.sharedData.mines.game[row][col]['bomb']) {
                    this.sharedData.mines.status = 'closed'
                    this.$emit('lost', this)
                } else {
                    let areBombsArround = this.checkSurroundingBombs(row, col)
                    if (!areBombsArround) {
                        this.openSurroundingBombs(row, col)
                    }
                }
            },

            flag (row, col) {
                this.sharedData.mines.game[row][col]['flagged'] = !this.sharedData.mines.game[row][col]['flagged']
            },

            checkSurroundingBombs(row, col) {
                let bombsAround = 0;
                for (let ir = -1; ir <= 1; ir++) {
                    for (let ic = -1; ic <= 1; ic++) {
                        bombsAround += this.isBomb(row + ir, col + ic)
                    }
                }
                
                if (bombsAround >= 1 && this.isNotOutside(row, col)) {
                    this.sharedData.mines.game[row][col]['show'] = bombsAround
                    return true
                }
                return false
            },

            openSurroundingBombs(row, col) {
                let noBomsRows = []
                for (let ir = -1; ir <= 1; ir++) {
                    for (let ic = -1; ic <= 1; ic++) {
                        this.open(row + ir, col + ic)
                        let areBombsArround = this.checkSurroundingBombs(row + ir, col + ic)
                        if (!areBombsArround && this.isNotOutside(row + ir, col + ic)) {
                            if (!this.sharedData.mines.game[row + ir][col + ic]['clicked']) {
                                noBomsRows.push({
                                    row: row + ir,
                                    col: col + ic,
                                })
                            }
                        }
                    }
                }

                noBomsRows.forEach(field => {
                    this.click(field.row, field.col)
                })
            },

            open(row, col) {
                if(this.isNotOutside(row, col)) {
                    this.sharedData.mines.game[row][col]['open'] = 1
                }
            },

            isBomb(row, col) {
                if (this.isNotOutside(row, col)) {
                    return this.sharedData.mines.game[row][col]['bomb']
                }

                return 0
            },

            isNotOutside(row, col) {
                return (row < this.minesLength && row >= 0) && (col < this.minesLength && col >= 0)
            }
        }
        
    }
</script>

<style>
.mines-row {
    display: flex;
}

.mines-element {
    border: solid 1px;
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
}

.mine-open {
    background-color: gray;
}

.mine-exploded {
    background-color: red;
}
</style>