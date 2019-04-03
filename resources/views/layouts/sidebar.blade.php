</v-list-tile>
<a href="/home" class="router-link">
<v-list-tile @click="">
    <v-list-tile-action>
        <v-icon>dashboard</v-icon>
    </v-list-tile-action>
    <v-list-tile-content>
        <v-list-tile-title>Dashboard</v-list-tile-title>
    </v-list-tile-content>
</v-list-tile>
</a>
<a href="/invoice/list" class="router-link">
    <v-list-tile @click="">
        <v-list-tile-action>
            <v-icon>list_alt</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>
            <v-list-tile-title>Invoice</v-list-tile-title>
        </v-list-tile-content>
    </v-list-tile>
</a>
<v-list-tile @click="logout()">
    <v-list-tile-action>
        <v-icon>exit_to_app</v-icon>
    </v-list-tile-action>
    <v-list-tile-content>
        <v-list-tile-title>Logout</v-list-tile-title>
    </v-list-tile-content>
</v-list-tile>
