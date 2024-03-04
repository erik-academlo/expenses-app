@extends('layouts.app')
@section('content')
    <div id="expensesList" class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Expense</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Category</th>
                        </thead>
                        <tbody>
                        <tr v-for="expense in expenses">
                            <td>Gas</td>
                            <td>100</td>
                            <td>2021-10-10</td>
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
        </div>
    </div>
@endsection
@section('script')
    <script>
        const app = new Vue({
            el: '#expensesList',
            data: {
                expenses: [],
                categories: [],
            },
            methods: {
                getExpenses() {
                    axios.get('/api/v1/expenses')
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
                }
            },
            created() {
              this.getExpenses();
              this.getCategories();
            }
        });
    </script>
@endsection
