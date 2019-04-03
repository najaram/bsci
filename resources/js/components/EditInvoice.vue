<template>
    <div>
        <v-card flat>
            <v-card-text>
                <v-form v-model="valid" ref="invoiceForm" lazy-validation>
                    <v-container>
                        <h2>Edit Information</h2>
                        <v-divider></v-divider>
                        <v-layout row wrap>
                            <v-flex xs12 sm6>
                                <v-text-field box label="Name" v-model="customer_name" :rules="customerNameRules"></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6>
                                <v-text-field box label="Address" v-model="customer_address" :rules="customerAddRules"></v-text-field>
                            </v-flex>
                        </v-layout>
                        <v-layout row wrap>
                            <v-flex xs12 sm6>
                                <v-menu
                                        v-model="menu1"
                                        :close-on-content-click="false"
                                        full-width
                                        max-width="290"
                                >
                                    <template v-slot:activator="{ on }">
                                        <v-text-field
                                                box
                                                :value="formattedDate"
                                                clearable
                                                label="Invoice date"
                                                prepend-icon="event"
                                                v-on="on"
                                        ></v-text-field>
                                    </template>
                                    <v-date-picker
                                            v-model="date1"
                                            @change="menu1 = false"
                                    ></v-date-picker>
                                </v-menu>
                            </v-flex>
                            <v-flex xs12 sm6>
                                <v-text-field box label="Invoice Number" :rules="invoiceNumberRules" v-model="invoiceNumber"></v-text-field>
                            </v-flex>
                        </v-layout>
                        <v-layout row wrap>
                            <v-flex xs12 sm6>
                                <v-menu
                                        v-model="menu2"
                                        :close-on-content-click="false"
                                        full-width
                                        max-width="290"
                                >
                                    <template v-slot:activator="{ on }">
                                        <v-text-field
                                                box
                                                :value="formattedDueDate"
                                                clearable
                                                label="Invoice date"
                                                prepend-icon="event"
                                                v-on="on"
                                        ></v-text-field>
                                    </template>
                                    <v-date-picker
                                            v-model="date2"
                                            @change="menu2 = false"
                                    ></v-date-picker>
                                </v-menu>
                            </v-flex>
                            <v-flex xs12 sm6>
                                <v-textarea
                                        v-model="note"
                                        :rules="noteRules"
                                        box
                                        name="input-7-4"
                                        label="Note">
                                </v-textarea>
                            </v-flex>
                        </v-layout>
                        <br>
                        <h2>Products</h2>
                        <v-divider></v-divider>
                        <v-layout row wrap>
                            <v-flex xs12 sm6>
                                <v-select
                                        box
                                        @change="getProduct"
                                        :items="products"
                                        v-model="selectedProduct"
                                        label="Product Name"
                                        item-text="name"
                                        item-value="id"
                                ></v-select>
                            </v-flex>
                            <v-flex xs12 sm6>
                                <v-text-field box label="Product Quantity" v-model="productQty"></v-text-field>
                            </v-flex>
                        </v-layout>
                        <v-layout row wrap>
                            <v-flex xs12 sm6>
                                <v-text-field box label="Product Price" v-model="productPrice"></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6>
                                <v-text-field box label="Product Tax" v-model="productTax"></v-text-field>
                            </v-flex>
                        </v-layout>
                        <br>
                        <h2>Payment</h2>
                        <v-divider></v-divider>
                        <v-layout row wrap>
                            <v-flex xs12 sm6>
                                <v-select
                                        box
                                        :items="payments"
                                        v-model="selectedPayment"
                                        label="Payment Type"
                                        item-text="label"
                                        item-value="value"
                                ></v-select>
                            </v-flex>
                            <v-flex xs12 sm6>
                                <v-text-field box label="Payment Amount" v-model="paymentAmount"></v-text-field>
                            </v-flex>
                        </v-layout>
                        <v-layout row wrap>
                            <v-flex xs12 sm12>
                                <v-btn @click="update()" :disabled="!valid" color="primary">Save</v-btn>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-form>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
    import swal from 'sweetalert';
    import axios from 'axios';
    import moment from 'moment';
    export default {
        name: "CreateInvoice",
        data () {
            return {
                valid: false,
                active: null,
                date1: new Date().toISOString().substr(0, 10),
                date2: new Date().toISOString().substr(0, 10),
                menu1: false,
                menu2: false,
                customer_name: '',
                customer_address: '',
                customerNameRules: [
                    (v) => !!v || 'Name required'
                ],
                customerAddRules: [
                    (v) => !!v || 'Address required'
                ],
                invoiceNumberRules: [
                    (v) => !!v || 'Invoice Number required'
                ],
                noteRules: [
                    (v) => !!v || 'Notes required'
                ],
                invoiceNumber: '',
                note: '',
                products: [],
                selectedProduct: '',
                productQty: '',
                productName: '',
                productPrice: '',
                productTax: '',
                payments: [
                    {label: 'Cash', value: 'cash'},
                    {label: 'Check', value: 'check'},
                    {label: 'Credit', value: 'credit'},
                ],
                selectedPayment: '',
                paymentAmount: '',
                text: ''
            }
        },
        props: {
            propInvoice: {
                type: String,
                required: true
            }
        },
        mounted() {
            this.getProducts();
            this.getInvoice();
            this.valid = false;
        },
        methods: {
            next () {
                const active = parseInt(this.active);
                this.active = (active < 2 ? active + 1 : 0)
            },
            getProduct() {
                axios.get('/products/'+this.selectedProduct).then((response) => {
                    const product = response.data.data;
                    this.productName = product.name;
                    this.productQty = product.quantity;
                    this.productPrice = product.price;
                    this.productTax = product.tax;
                });
            },
            getInvoice() {
                axios.get('/invoice/'+this.propInvoice).then((response) => {

                    const product = response.data.data;
                    this.customer_name = product.customer_name;
                    this.customer_address = product.customer_address;
                    this.date1 = moment(product.invoice_date).format('YYYY-MM-DD');
                    this.invoiceNumber = product.invoice_number;
                    this.date2 = moment(product.invoice_due_date).format('YYYY-MM-DD');
                    this.note = product.invoice_note;
                    this.selectedProduct = this.checkProduct(product.product_name, this.products);
                    this.productQty = product.product_qty;
                    this.productPrice = product.product_price;
                    this.productTax = product.product_tax;
                    this.paymentAmount = product.payment_amount;
                    this.selectedPayment = product.payment_type;
                });
            },
            getProducts() {
                axios.get('/products').then((response) => {
                    this.products = response.data.data;
                });
            },
            checkProduct(product, customArr) {
                for (let i = 0; i < customArr.length; i++) {
                    if (typeof product === "number") {
                        if (customArr[i].id === product) {
                            return customArr[i].name;
                        }
                    } else {
                        if (customArr[i].name === product) {
                            return customArr[i].id
                        }
                    }

                }
            },
            update() {
                const payload = {
                    customer_name: this.customer_name,
                    customer_address: this.customer_address,
                    invoice_date: moment(this.date1).format('YYYY-MM-DD'),
                    invoice_number: this.invoiceNumber,
                    invoice_due_date: moment(this.date2).format('YYYY-MM-DD'),
                    invoice_note: this.note,
                    product_name: this.checkProduct(this.selectedProduct, this.products),
                    product_qty: this.productQty,
                    product_price: this.productPrice,
                    product_tax: this.productTax,
                    payment_type: this.selectedPayment,
                    payment_amount: this.paymentAmount
                };
                axios.put('/invoice/'+this.propInvoice, payload).then((response) => {
                    this.text = response.data.data;
                    swal({
                        title: 'Nice!',
                        text: 'You have updated the invoice',
                        icon: 'success'
                    });
                    this.$refs.invoiceForm.reset();
                })
            }
        },
        computed: {
            formattedDate() {
                return this.date1 ? moment(this.date1).format('YYYY-MM-DD') : '';
            },
            formattedDueDate() {
                return this.date2 ? moment(this.date2).format('YYYY-MM-DD') : '';
            }
        }
    }
</script>

<style scoped>

</style>
