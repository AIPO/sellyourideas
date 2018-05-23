<template>
    <div>
        <form @submit.prevent="addIdea" class="md-3">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Title" v-model="idea.title">
                <textarea class="form-control" placeholder="Your content goes here..." v-model="idea.body"></textarea>
                <button type="submit" class="btn btn-light btn-block">Save</button>
            </div>
        </form>
        <h2>Ideas</h2>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li v-bind:class="[{disabled:!pagination.prev_page_url}]" class="page-item">
                    <a class="page-link" href="#" @click="fetchIdeas(pagination.prev_page_url)">Previous</a>
                </li>
                <li class="page-item disabled">
                    <a class="page-link text-dark" href="#">Page {{pagination.current_page}} of
                        {{pagination.last_page}}</a>
                </li>
                <li v-bind:class="[{disabled:!pagination.next_page_url}]" class="page-item">
                    <a class="page-link" href="#" @click="fetchIdeas(pagination.next_page_url)">Next</a>
                </li>
            </ul>
        </nav>
        <div class="card card-body mb-2" v-for="idea in ideas" v-bind:key="idea.id">
            <h3>{{idea.title}}</h3>
            <p>{{idea.body}}</p>
            <hr>
            <button @click="editIdea(idea)" class="btn btn-warning">Edit</button>
            <button @click="deleteIdea(idea.id)" class="btn btn-danger">Delete</button>
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
                    page_url = page_url || '/api/ideas';
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
                    };
                    this.pagination = pagination;
                },
                deleteIdea(id) {
                    if (confirm('are you sure?')) {
                        fetch(`api/idea/${id}`, {
                            method: 'delete'
                        })
                            .then(res => res.json())
                            .then(data => {
                                alert('Deleted');
                                this.fetchIdeas();
                            })
                            .catch(err => console.log(err));
                    }
                },
                addIdea() {
                    if (this.edit === false) {
                        //add
                        fetch('api/idea', {
                            method: 'post',
                            body: JSON.stringify(this.idea),
                            headers: {
                                'content-type': 'application/json',
                            }
                        })
                            .then(res => res.json())
                            .then(data => {
                                this.idea.title = '';
                                this.idea.body = '';
                                alert('Idea added');
                                this.fetchIdeas();
                            })
                            .catch(err => console.log(err));
                    } else {
                        fetch('api/idea', {
                            method: 'put',
                            body: JSON.stringify(this.idea),
                            headers: {
                                'content-type': 'application/json',
                            }
                        })
                            .then(res => res.json())
                            .then(data => {
                                this.idea.title = '';
                                this.idea.body = '';
                                alert('Idea updated');
                                this.fetchIdeas();
                            })
                            .catch(err => console.log(err));

                    }
                },
                editIdea(idea){
                   this.edit =true;
                   this.idea.id =idea.id;
                   this.idea.idea_id= idea.id;
                   this.idea.title = idea.title;
                   this.idea.body = idea.body;
                }
            }
    };
</script>
