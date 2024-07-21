<table class="table table-bordered table-hover" >
                            <thead>
                                <tr>
                                    <td>Id</td>
                                    <td>Author</td>
                                    <td>Title</td>
                                    <td>Category</td>
                                    <td>Status</td>
                                    <td>Image</td>
                                    <td>Tags</td>
                                    <td>Comments</td>
                                    <td>Date</td>
                                </tr>
                            </thead>
                            <tbody>
                               <?php findAllPosts(); ?>
                            </tbody>
                        </table>

<?php 
   deletePost();
?>