
class SetCounts {
    // Private
    //#region 
    #setCount = {};

    #wrapAdd(value) {
        if (this.#setCount[value] == undefined) {
            this.#setCount[value] = 1
        } else {
            this.#setCount[value] += 1
        }
    }

    #set(value, count) {
        this.#setCount[value] = count
    }

    #getOneArray(array) {
        if(Array.isArray(array)) {
            let result = []
            for(const item of array) {
                result = result.concat(this.#getOneArray(item))
            }
            return result
        } else {
            return array
        }
    }

    //#endregion

    // Public
    constructor(...values) {
        this.add(values)
    }

    add(...values) {
        values = this.#getOneArray(values)
        values.forEach((value) => {
            this.#wrapAdd(value)
        })
    }

    get(value) {
        return this.#setCount[value]
    }

    getAll() {
        return this.#setCount
    }

    extendSet(set) {
        for (const item in set.getAll()) {
            if (this.get(item) === undefined) {
                this.#set(item, set.get(item))
            } else {
                if (this.get(item) < set.get(item)) {
                    this.#set(item, set.get(item))
                }
            }
        }
    }
}