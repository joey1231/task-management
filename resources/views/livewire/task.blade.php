<div class="container" >
    <div class="row">
        <div class="col-md-6">
               <form wire:submit="store"class="row g-3">
                <div class="mb-3">
                  <label for="exampleFormControlInput1" class="form-label">Name</label>
                 <input wire:model="taskForm.name" type="text"  class="form-control" id="exampleFormControlInput1" placeholder="Task Name">
                </div>

              <div class="col-auto">
                <button type="submit" class="btn btn-primary mb-3">Save</button>
              </div>
            </form>
        </div>
        <div class="col-md-6">
            <ul draggable-parent class="list-group">
                 @foreach($tasks as $task)
              <li draggable-children="{{$task->id}}" draggable="true" wire:key="{{$task->id}}" class="list-group-item d-flex justify-content-between align-items-center">
               {{$task->name}}
                <span class="badge rounded-pill"><button class="btn btn-primary" wire:click="edit({{$task->id}})">Edit</button> <button class="btn btn-danger" wire:click="delete({{$task->id}})">Delete</button></span>
              </li>
               @endforeach

            </ul>

        </div>
    </div>

</div>

<script>

     document.addEventListener('livewire:initialized', () => {
        function initilizeEvent() {
            let parent = document.querySelector('[draggable-parent]');

            parent.querySelectorAll('[draggable-children]').forEach(el => {

                    el.addEventListener('dragstart',e => {
                        console.log('start')
                        e.target.setAttribute('dragging',true);
                    });
                    el.addEventListener('drop',e => {
                        e.target.classList.remove('list-group-item-primary')

                        let draggingElement = parent.querySelector('[dragging]');
                        let children = parent.querySelectorAll('[draggable-children]');
                        let targetIndex =0;
                        let draggingIndex = 0;
                        for(var i =0;i < children.length;i++) {
                             if(children[i]== e.target) {
                                targetIndex = i;
                             }else if(children[i]== draggingElement) {
                                draggingIndex = i;
                             }

                        }


                        if(targetIndex <= draggingIndex) {
                            e.target.before(draggingElement)
                         } else {
                            e.target.after(draggingElement)
                         }

                        let component = Livewire.find(
                            e.target.closest('[wire\\:id]').getAttribute('wire:id')
                        );

                        let taskIds = Array.from(parent.querySelectorAll('[draggable-children]')).map(child => child.getAttribute('draggable-children'));
                        component.call('sorts',taskIds);
                    });
                    el.addEventListener('dragenter',e => {
                        e.target.classList.add('list-group-item-primary')
                        e.preventDefault();
                    });
                     el.addEventListener('dragover',e => {
                        e.preventDefault();
                    });
                    el.addEventListener('dragleave',e => {
                        console.log('enter')
                         e.target.classList.remove('list-group-item-primary')
                    });

                    el.addEventListener('dragend',e => {
                        console.log('end')
                        e.target.removeAttribute('dragging');
                    });
                });
        }

        initilizeEvent();

    });

</script>
