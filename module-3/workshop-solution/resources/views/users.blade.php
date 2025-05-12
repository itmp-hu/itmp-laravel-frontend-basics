<x-layout>
    <x-slot name="title">Users</x-slot>
    <ul>
        <?php
            foreach ($users as $user) {
                echo "<li>$user->name</li>";
            }
        ?>
    </ul>
</x-layout>