@extends('layouts.app')
@section('content')
    <div id="expensesList" class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-end">
                <p class="text-center">@{{ expenses.total }} gastos en total</p>
                <div class="text-end">
                    <button class="btn btn-primary my-2" @click="triggerFileInput">Cargar Excel</button>
                    <input class="d-none" type="file" id="fileInput" ref="fileInput" @change="handleFileUpload" accept=".xls,.xlsx,.xlsm,.xlsb,.xlt,.xltm,.xltx,.xla,.xlam,.xll,.xlw">
                </div>
            </div>
            <div class="card shadow border-0">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Gasto</th>
                            <th>Monto</th>
                            <th>Fecha</th>
                            <th>Categoría</th>
                        </thead>
                        <tbody>
                        <tr v-for="expense in expenses.data">
                            <td>@{{ expense.name }}</td>
                            <td>@{{ expense.amount }}</td>
                            <td>@{{ expense.date }}</td>
                            <td>
                                <select @change="updateExpenseCategory(expense)" class="form-select" v-model="expense.category_id">
                                    <option v-for="category in categories" :key="category.id" :value="category.id">@{{ category.name }}</option>
                                </select>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <nav class="mt-3">
                <ul class="pagination justify-content-center">
                    <li class="page-item" :class="!expenses.prev_page_url ? 'disabled' : ''">
                        <button class="page-link" @click="getExpenses(expenses.prev_page_url)">Previous</button>
                    </li>
                    <li class="page-item" :class="!expenses.next_page_url ? 'disabled' : ''">
                        <button class="page-link" @click="getExpenses(expenses.next_page_url)">Next</button>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
@endsection
@section('script')
    <script>
        const app = new Vue({
            el: '#expensesList',
            data: {
                expenses: {},
                categories: [],
            },
            methods: {
                getExpenses(endpoint = '/api/v1/expenses') {
                    axios.get(endpoint)
                        .then(response => {
                            this.expenses = response.data;
                        }).catch(() => {
                            alert('No pudimos obtener los gastos');
                    })
                },
                getCategories() {
                    axios.get('/api/v1/categories')
                        .then(response => {
                            this.categories = response.data;
                        }).catch(() => {
                            alert('No pudimos obtener las categorías');
                    })
                },
                updateExpenseCategory(expense) {
                    axios.put(`/api/v1/expenses/${expense.id}`, expense)
                        .then(() => {
                            alert('Categoría actualizada');
                        }).catch(() => {
                            alert('No pudimos actualizar la categoría');
                        })
                },
                triggerFileInput() {
                    this.$refs.fileInput.click();
                },
                handleFileUpload() {
                    let file = this.$refs.fileInput.files[0];
                    let formData = new FormData();
                    formData.append('file', file);

                    axios.post('/api/v1/expenses/import', formData)
                        .then(() => {
                            alert('Estamos procesando tu archivo, te enviaremos un correo cuando esté listo. Puedes seguir trabajando en otras cosas mientras tanto.');
                            this.getExpenses();
                        }).catch(() => {
                            alert('No pudimos importar los gastos');
                        })
                }
            },
            created() {
              this.getExpenses();
              this.getCategories();
            }
        });
    </script>
@endsection
