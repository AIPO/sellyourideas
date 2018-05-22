<template>
    <div>
        <h2>Ideas</h2>
        <div class="card card-body mb-2" v-for="idea in ideas" v-bind:key="idea.id">
            <h3>{{idea.title}}</h3>
            <p>{{idea.body}}</p>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                ideas: [],
                idea: {
                    id: '',
                    title: '',
                    body: ''
                },
                idea_id: '',
                pagination: {},
                edit: false
            }
        },
        created() {

            this.fetchIdeas()
        },
        methods:
            {
                fetchIdeas(page_url) {
                    let vm = this;
                    page_url = page_url || '/api/ideas'
                    fetch(page_url)
                        .then((res => res.json()))
                        .then(res => {
                            this.ideas = res.data;
                            vm.makePagination(res.meta, res.links);
                        })
                        .catch(err => console.log(err));
                },
                makePagination(meta, links) {
                    let pagination = {
                        current_page: meta.current_page,
                        last_page: meta.last_page,
                        next_page_url: links.next,
                        prev_page_url: links.prev
                    }
                    this.pagination = pagination;
                }
            }
    };
</script>
