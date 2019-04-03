<template>
    <div>
        <h2>Invoice List</h2>
        <v-divider></v-divider>
        <v-btn @click="createInvoice()" color="primary">Create Invoice</v-btn>
        <v-data-table
                :headers="headers"
                :items="invoices"
                class="elevation-1"
        >
            <template v-slot:items="props">
                <td class="text-xs-left">{{ props.item.id }}</td>
                <td class="text-xs-left">{{ props.item.customer_name }}</td>
                <td class="text-xs-left">{{ props.item.customer_address }}</td>
                <td class="text-xs-left">
                    <v-btn
                            @click="goto(props.item.id)"
                            slot="activator"
                            icon
                            light>
                        <v-icon color="light-blue lighten-1">visibility</v-icon>
                    </v-btn>
                </td>
                <td class="text-xs-left">
                    <v-btn
                            @click="gotoEdit(props.item.id)"
                            slot="activator"
                            icon
                            light>
                        <v-icon color="light-blue lighten-1">create</v-icon>
                    </v-btn>
                </td>
                <td class="text-xs-left">
                    <v-btn
                            @click="trash(props.item.id)"
                            slot="activator"
                            icon
                            light>
                        <v-icon color="red darken-1">delete</v-icon>
                    </v-btn>
                </td>
            </template>
        </v-data-table>
    </div>
</template>

<script>
    import axios from 'axios';
    export default {
        name: "ViewInvoice",
        data () {
            return {
                headers: [
                    {
                        text: '#',
                        align: 'left',
                        sortable: false,
                        value: 'id'
                    },
                    {
                        text: 'Customer Address',
                        align: 'left',
                        sortable: false,
                        value: 'customer_address'
                    },
                    {
                        text: 'Customer Address',
                        align: 'left',
                        sortable: false,
                        value: 'customer_address'
                    },
                    { text: "View", value: false, align: "left", sortable: false },
                    { text: "Edit", value: false, align: "left", sortable: false },
                    { text: "Delete", value: false, align: "left", sortable: false },

                ],
                invoices: []
            }
        },
        mounted () {
            this.getInvoices();
        },
        methods: {
            getInvoices() {
                axios.get('/invoice').then((response) => {
                    this.invoices = response.data.data;
                })
            },
            goto(id) {
                window.location.assign('/invoice/'+id+'/show');
            },
            gotoEdit(id) {
                window.location.assign('/invoice/'+id+'/edit');
            },
            createInvoice() {
                window.location.assign('/invoice/create');
            },
            trash(invoice) {
                axios.delete('/invoice/'+invoice).then((response) => {
                    swal({
                        title: 'Good!',
                        text: 'You have deleted the invoice',
                        icon: 'success'
                    }).then(() => {
                        setTimeout(() => {
                            window.location.reload()
                        }, 1000);
                    })
                }).catch(e => console.log(e));
            }
        }
    }
</script>

<style scoped>

</style>
