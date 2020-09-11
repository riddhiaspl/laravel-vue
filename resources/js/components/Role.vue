<template>
    <div>
        <h3>Roles</h3>

        <div id="errorMsg"></div>
        <form class="form-inline py-4" @submit.prevent="saveData()">
            <div class="form-group mx-sm-3 mb-2">
                <label for="role" class>Role : &nbsp;</label>
                <input
                    type="text"
                    v-model="role"
                    name="role"
                    class="form-control"
                    id="role"
                    size="40"
                />
                <input
                    type="hidden"
                    v-model="role_id"
                    name="role_id"
                    id="role-id"
                />
            </div>
            <button type="submit" id="submitBtn" class="btn btn-primary mb-2">
                Add Role
            </button>
            <button
                type="button"
                class="btn btn-primary mb-2 mx-3"
                v-on:click="cancelData()"
            >
                Cancel
            </button>
        </form>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Role</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="role in roles.data" :key="role.id">
                    <th scope="row">{{ role.id }}</th>
                    <td>{{ role.role }}</td>
                    <td>
                        <a
                            href="#"
                            class="btn btn-primary"
                            v-on:click="updateData(role.id, role.role)"
                            >Edit</a
                        >
                    </td>
                    <td>
                        <a
                            href="#"
                            class="btn btn-danger"
                            v-on:click="deleteData(role.id)"
                            >Delete</a
                        >
                    </td>
                </tr>
            </tbody>
        </table>

        <pagination
            class="justify-content-center"
            :data="roles"
            @pagination-change-page="getRoles"
        ></pagination>
    </div>
</template>

<script>
export default {
    data() {
        return {
            roles: "",
            role: "",
            role_id: 0,
            active_page: 1,
            errorMsg: ""
        };
    },
    methods: {
        cancelData() {
            this.role = "";
            this.role_id = 0;
            $("#errorMsg")
                .html("")
                .removeClass(" alert alert-danger alert-success");
            $("#submitBtn").html("Add Role");
        },
        updateData(roleid, rolename) {
            this.role = rolename;
            this.role_id = roleid;
            $("#errorMsg")
                .html("")
                .removeClass(" alert alert-danger alert-success");
            $("#submitBtn").html("Update Role");
        },
        deleteData(roleid) {
            if (confirm("Are you sure you want to delete this role ?")) {
                axios
                    .delete("/admin/role/delete/" + roleid, {
                        role_id: roleid
                    })
                    .then(response => {
                        $("#errorMsg")
                            .html("Role deleted Successfully !")
                            .removeClass(" alert alert-danger")
                            .addClass("alert alert-success");

                        this.getRoles(this.active_page);
                    });
            }
        },
        getRoles(page = 1) {
            axios.get("role/list?page=" + page).then(response => {
                this.active_page = response.data.current_page;
                this.roles = response.data;
            });
        },
        saveData() {
            var axiosUrl = "";
            var sucMsg = "Role Added Successfully !";

            if (this.role_id > 0) {
                var sucMsg = "Role Updated Successfully !";
            }

            axios
                .post("/admin/role", { role: this.role, role_id: this.role_id })
                .then(response => {
                    this.role = "";
                    this.role_id = "";
                    $("#submitBtn").html("Add Role");
                    $("#errorMsg")
                        .html(sucMsg)
                        .removeClass(" alert alert-danger")
                        .addClass("alert alert-success");

                    this.getRoles(this.active_page);
                })
                .catch(function(error) {
                    if (error.response) {
                        $("#errorMsg")
                            .html(error.response.data.errors.role[0])
                            .addClass("alert alert-danger");
                    }
                });
        }
    },
    mounted() {
        this.getRoles();
    }
};
</script>
